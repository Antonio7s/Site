<?php

namespace App\Http\Controllers\Pagamento;

use App\Helpers\ValorSeguroHelper;

use Illuminate\Support\Facades\Log;

use App\Http\Controllers\Controller;

use App\Models\Horario;
use App\Models\Agendamento;
use App\Models\ServicoDiferenciado;

use App\Models\User;
use Illuminate\Support\Arr;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\AsaasService;

use Carbon\Carbon;


class PagamentoController extends Controller
{
    protected $asaasService;

    public function __construct(AsaasService $asaasService)
    {
        $this->asaasService = $asaasService;
    }

    // // Exibe a tela de checkout
    // public function index()
    // {
    //     $horario = Horario::findOrFail(1);
    //     $user = Auth::user();
    //     $agenda = $horario->agenda;
    //     $medico = $horario->agenda->medico;
    //     $clinica = $horario->agenda->medico->clinica;
    //     $procedimento = $horario->procedimento;

    //     return view('pagamento.checkout', compact('horario', 'agenda', 'clinica', 'medico', 'procedimento', 'user'));
    // }


    public function index(Request $request)
    {
        Log::debug('Iniciando PagamentoController@index', ['request' => $request->all()]);

        $horario_id = $request->input('horario_id');
        Log::info('Buscando horário ID: ' . $horario_id);

        $horario = Horario::with(['agenda.medico.clinica', 'procedimento'])
                        ->where('id', $horario_id)
                        ->first();

        if (!$horario) {
            Log::error('Horário não encontrado', ['horario_id' => $horario_id]);
            return redirect()->back()->with('error', 'Horário não encontrado.');
        }

        Log::debug('Horário encontrado', ['horario' => $horario->toArray()]);

        try {
            $agenda = $horario->agenda;
            $medico = $agenda->medico;
            $clinica = $medico->clinica;
            $procedimento = $horario->procedimento;

            Log::debug('Relacionamentos carregados', [
                'clinica_id' => $clinica->id,
                'procedimento_id' => $procedimento->id,
                'valor_procedimento' => $procedimento->valor
            ]);

            // Verificação do serviço diferenciado
            Log::info('Verificando serviços diferenciados', [
                'clinica' => $clinica->id,
                'procedimento' => $procedimento->id,
                'data_atual' => Carbon::today()->toDateString()
            ]);

            $servicoDiferenciado = ServicoDiferenciado::where('clinica_id', $clinica->id)
                ->where('procedimento_id', $procedimento->id)
                ->whereDate('data_inicial', '<=', Carbon::today())
                ->whereDate('data_final', '>=', Carbon::today())
                ->first();

            if ($servicoDiferenciado) {
                Log::notice('Serviço diferenciado aplicado', [
                    'servico_id' => $servicoDiferenciado->id,
                    'valor_original' => $procedimento->valor,
                    'preco_customizado' => $servicoDiferenciado->preco_customizado,
                    'periodo' => $servicoDiferenciado->data_inicial . ' - ' . $servicoDiferenciado->data_final
                ]);
            } else {
                Log::info('Nenhum serviço diferenciado ativo encontrado');
            }

            $valor = $servicoDiferenciado 
                ? $servicoDiferenciado->preco_customizado 
                : $procedimento->valor;

            Log::debug('Valor final calculado', ['valor_final' => $valor]);

            // Gera o token criptografado com o valor e o horário
            $valorToken = ValorSeguroHelper::assinar($valor, $horario->id);

            return view('pagamento.checkout', [
                'clinica' => $clinica,
                'horario' => $horario,
                'medico' => $medico,
                'data' => $horario->data,
                'procedimento' => $procedimento,
                'agenda' => $agenda,
                'valorToken'   => $valorToken,
                'valor' => $valor,
            ]);

        } catch (\Exception $e) {
            Log::error('Falha no processo de checkout', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->back()->with('error', 'Erro ao processar o pedido');
        }
    }


    public function store(Request $request)
    {
        // Recupere os dados enviados via POST
        $clinica_id = $request->input('clinica_id');
        $medico_id = $request->input('medico_id');
        $horario   = $request->input('horario');
        $data      = $request->input('data');

        // Aqui você pode fazer a lógica para salvar o agendamento ou preparar a view de confirmação/compra
        return view('pagamento.checkout', compact('clinica_id', 'medico_id', 'horario', 'data'));
    }

    // Gera cobrança para pagamento via PIX
    public function gerarPix(Request $request)
    {
        $request->validate([
            'descricao' => 'required|string',
            'clinica_id'    => 'required|integer',  // Necessário para recuperar os splits
        ]);

        $user = Auth::user();
        $horario = Horario::findOrFail($request->horario_id); // Usa o ID do request

        // Verifica se o usuário já possui customer_id, se não, cria o cliente no Asaas
        if (!$user->customer_id) {
            $cliente = $this->asaasService->criarCliente(
                $user->name,
                $user->cpf,
                $user->email,
                $user->telefone
            );
            $user->update(['customer_id' => $cliente['id']]);
            $customerId = $cliente['id'];
        } else {
            $customerId = $user->customer_id;
        }

        // Verifica e extrai o valor do token
        $dadosValor = ValorSeguroHelper::verificar($request->valor_token);

        // Confirma que o horário bate com o token
        if ((int)$dadosValor['horario_id'] !== (int)$request->horario_id) {
            \Log::warning('Tentativa de manipulação detectada no valor_token', [
                'esperado_horario_id' => $dadosValor['horario_id'],
                'recebido_horario_id' => $request->horario_id,
            ]);

            return redirect()->route('pagamento.falhaCartao')
                ->with('error', 'Informações inválidas detectadas. Tente novamente.');
        }

        $valorFinal = $dadosValor['valor'];


        $clinica_id = $request->input('clinica_id');

        // Cria a cobrança PIX
        $cobranca = $this->asaasService->criarCobrancaPix(
            $customerId,
            $valorFinal,
            $request->descricao,
            $clinica_id,
            $user->cpf
        );

        if (!isset($cobranca['id'])) {
            return redirect()->route('pagamento.falhaPix');
        }

        // Criação do agendamento
        //obs:
        //$horario = Horario::findOrFail(1); // Aqui você pode alterar conforme necessário
        $agendamento = new Agendamento();
        $agendamento->user_id = $user->id;
        $agendamento->horario_id = $horario->id;
        $agendamento->data = Carbon::now(); // Isso irá definir data e hora atuais
        $agendamento->pagamento_id = $cobranca['id']; // Atribui o id do pagamento (pix); // id da cobranca para o webhook resgatar.
        //$agendamento->valor = $request->valor;
        //$agendamento->descricao = $request->descricao;
        $agendamento->status = 'pendente';  // pendente indica aguardando pagamento
        $agendamento->save();

        // Obtém o QR Code PIX usando o ID da cobrança
        $qrCodePix = $this->asaasService->obterQrCodePix($cobranca['id']);

        if (!isset($qrCodePix['encodedImage'])) {
            return redirect()->route('pagamento.falhaPix');
        }

        // Redireciona para a view de pagamento Pix passando os dados necessários
        return view('pagamento/pagamento-pix', [
            'qrcode' => 'data:image/png;base64,' . $qrCodePix['encodedImage'],
            'valor'  => $valorFinal,
            'agendamento_id' => $agendamento->id,
        ]);
    }


    // Método para gerar o pagamento  com o cartão
    public function finalizarCartao(Request $request)
    {
        Log::info('Valor recebido no Cartão', ['amount' => $request->amount]);
        
        $request->validate([
            'cardName'      => 'required|string',
            'cardNumber'    => 'required|string',
            'cardExpiry'    => 'required|string', // Exemplo: "12/25"
            'cardCVV'       => 'required|string',
           // 'installments'  => 'required|integer',
            //'amount'        => 'required|numeric',  // Valor a ser cobrado
            'descricao'     => 'required|string',   // Descrição do pagamento
            'clinica_id'    => 'required|integer',  // Necessário para recuperar os splits
            // 'horario_id'    => 'required|integer',  // ID do horário
            // 'postalCode'    => 'required|string',   // CEP
            // 'addressNumber' => 'required|string',   // Número do endereço
        ]);

        $user = Auth::user();
        $horario = Horario::findOrFail($request->horario_id); // Usa o ID do request

         // Verifica se já existe um agendamento para esse horário
        if (Agendamento::where('horario_id', $horario->id)->exists()) {
            return redirect()->route('pagamento.horarioIndisponivel')
                ->with('error', 'Já existe um agendamento para esse horário.');
        }

        // Verifica se o usuário já possui customer_id; se não, cria um cliente no Asaas
        if (!$user->customer_id) {
            $cliente = $this->asaasService->criarCliente(
                $user->name,
                $user->cpf,
                $user->email,
                $user->telefone
            );
            $user->update(['customer_id' => $cliente['id']]);
            $customerId = $cliente['id'];
        } else {
            $customerId = $user->customer_id;
        }


        // Verifica e extrai o valor do token
        $dadosValor = ValorSeguroHelper::verificar($request->valor_token);

        // Confirma que o horário bate com o token
        if ((int)$dadosValor['horario_id'] !== (int)$request->horario_id) {
            \Log::warning('Tentativa de manipulação detectada no valor_token', [
                'esperado_horario_id' => $dadosValor['horario_id'],
                'recebido_horario_id' => $request->horario_id,
            ]);

            return redirect()->route('pagamento.falhaCartao')
                ->with('error', 'Informações inválidas detectadas. Tente novamente.');
        }

        $valorFinal = $dadosValor['valor'];

        // Extrair os dados do cartão (dividindo a validade em mês e ano)
        $cardExpiry = explode('/', $request->cardExpiry);

        $creditCard = [
            'number'         => $request->cardNumber,
            'holderName'     => $request->cardName,
            'expirationMonth'=> trim($cardExpiry[0]),
            'expirationYear' => trim($cardExpiry[1]),
            'cvv'            => $request->cardCVV,
        ];

        try {
            // Chama o método para criar a cobrança via cartão, enviando também o clinica_id para os splits
            $cobranca = $this->asaasService->criarCobrancaCartao(
                $customerId,
                $valorFinal,
                $request->descricao,
                $creditCard,
                $request->clinica_id,

                $request->postalCode, //cep
                $request->addressNumber, //numero

                //dados do user
                $user->name,
                $user->cpf,
                $user->email,
                $user->telefone,
            );


            // 4) Debug: log de status
            \Log::info('Pagamento recebido no controller', [
                'id'     => $cobranca['id'] ?? null,
                'status' => $cobranca['status'] ?? null,
            ]);


            // 5) Verifica status
            if (
                isset($cobranca['id'], $cobranca['status'])
                && strtoupper($cobranca['status']) === 'CONFIRMED'
            ) {

                \Log::info('Status CONFIRMED detectado, iniciando criação de agendamento.', [
                    'pagamento_id' => $cobranca['id']
                ]);


                \Log::info('Dados recebidos para salvar agendamento', $request->all());

                // 6) Cria agendamento com status “agendado”
                $ag = new Agendamento();
                $ag->user_id      = $user->id;
                $ag->horario_id = $horario->id;
                $ag->data         = Carbon::now();
                $ag->pagamento_id = $cobranca['id'];
                $ag->status       = 'agendado';
                $ag->save();

                return redirect()
                    ->route('pagamento.sucessoCartao', ['payment_id' => $cobranca['id']]);
            }

            return redirect()
                ->route('pagamento.falhaCartao')
                ->with('error', 'Pagamento não confirmado.');

        } catch (\Exception $e) {

            \Log::error('Erro ao processar pagamento com cartão', [
                'mensagem' => $e->getMessage(),
                'trace'    => $e->getTraceAsString()
            ]);
            
            return redirect()
                ->route('pagamento.falhaCartao')
                ->with('error', 'Erro ao processar pagamento: ' . $e->getMessage());
        }


    }




    public function pagamentoPix()
    {
        return view('pagamento/pagamento-pix');
    }

    public function falhaPix()
    {
        return view('pagamento/falha-pix');
    }


    public function sucessoPix()
    {
        return view('pagamento/sucesso-pix');
    }

    public function falhaCartao()
    {
        return view('pagamento/falha-cartao');
    }


    public function sucessoCartao()
    {
        return view('pagamento/sucesso-cartao');
    }
    

    public function horarioIndisponivel()
    {
        return view('pagamento/horario-indisponivel');
    }
    

    public function verificarPagamento(Request $request)
    {
        // Recupera o id do agendamento enviado na requisição
        $agendamentoId = $request->input('agendamento_id');
        $userId = Auth::id();

        \Log::info('Verificando pagamento para ID:', [
            'agendamento_id' => $request->input('agendamento_id'),
            'user_id' => Auth::id(),
        ]);

        // Busca o agendamento específico do usuário com status "agendado"
        $agendamento = Agendamento::where('user_id', $userId)
                            ->where('id', $agendamentoId)
                            ->where('status', 'agendado')
                            ->first();

        return response()->json([
            'aprovado' => $agendamento ? true : false
        ]);
    }



    public function apikey_edit()
    {
        return view ('admin/sub-diretorios/api_key');
    }
}