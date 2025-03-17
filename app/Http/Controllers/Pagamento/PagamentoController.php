<?php

namespace App\Http\Controllers\Pagamento;

use App\Http\Controllers\Controller;

use App\Models\Horario;
use App\Models\Agendamento;
use App\Models\User;


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
        // Obter o ID do horário via POST
        $horario_id = $request->input('horario_id');

        // Busque as informações do horário no banco de dados
        $horario = Horario::with(['agenda.medico.clinica', 'procedimento'])
                        ->where('id', $horario_id)
                        ->first();

        // Se o horário não for encontrado, redirecione ou trate o erro
        if (!$horario) {
            return redirect()->back()->with('error', 'Horário não encontrado.');
        }

        // Pegue todos os dados do procedimento relacionado ao horário
        $procedimento = $horario->procedimento;  // Acesso completo ao objeto 'procedimento'
        
        
        // A partir do horário, você pode acessar a agenda e a clínica
        $agenda = $horario->agenda;         // Agenda associada ao horário
        $medico = $agenda->medico;
        $clinica = $medico->clinica;        // Clinica associada à agenda

        // Pegue os dados da agenda e do procedimento relacionados
        //$agenda_id = $horario->agenda_id;
        //$procedimento_id = $horario->procedimento_id;
        $medico_id = $horario->agenda->medico_id; // Supondo que 'agenda' tenha uma relação com 'medico'
        $data = $horario->data; // Ou qualquer outra informação que você precise
        $clinica_id = $horario->agenda->clinica_id;
        // Agora, você pode passar os dados para a view

        return view('pagamento.checkout', compact('clinica', 'horario', 'medico', 'data', 'procedimento', 'agenda'));
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
            'valor' => 'required|numeric',
            'descricao' => 'required|string'
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

        $clinica_id = $request->input('clinica_id');

        // Cria a cobrança PIX
        $cobranca = $this->asaasService->criarCobrancaPix(
            $customerId,
            $request->valor,
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
            'valor'  => $request->valor
        ]);
    }





    // Exemplo de finalização de pagamento com Cartão de Crédito
    public function finalizarCartao(Request $request)
    {
        $request->validate([
            'cardName'    => 'required|string',
            'cardNumber'  => 'required|string',
            'cardExpiry'  => 'required|string',
            'cardCVV'     => 'required|string',
            'installments'=> 'required|integer',
        ]);

        // Aqui você integraria com o serviço de pagamento com cartão.
        // Esta é apenas uma simulação.
        return response()->json([
            'status'  => 'sucesso',
            'message' => 'Pagamento com cartão finalizado com sucesso.'
        ]);
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


    public function verificarPagamento()
    {
        // Obtém o ID do usuário logado
        $userId = Auth::id();

        // Busca um agendamento do usuário com status "agendado"
        $agendamento = Agendamento::where('user_id', $userId)
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