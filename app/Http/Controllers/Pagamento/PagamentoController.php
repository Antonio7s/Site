<?php

namespace App\Http\Controllers\Pagamento;

use App\Http\Controllers\Controller;

use App\Models\Horario;
use App\Models\Agendamento;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\AsaasService;

class PagamentoController extends Controller
{
    protected $asaasService;

    public function __construct(AsaasService $asaasService)
    {
        $this->asaasService = $asaasService;
    }

    // Exibe a tela de checkout
    public function index()
    {
        $horario = Horario::findOrFail(1);
        $user = Auth::user();
        $agenda = $horario->agenda;
        $medico = $horario->agenda->medico;
        $clinica = $horario->agenda->medico->clinica;
        $procedimento = $horario->procedimento;

        return view('pagamento.checkout', compact('horario', 'agenda', 'clinica', 'medico', 'procedimento', 'user'));
    }

    // Gera cobrança para pagamento via PIX
    public function gerarPix(Request $request)
    {
        $request->validate([
            'valor' => 'required|numeric',
            'descricao' => 'required|string'
        ]);

        $user = Auth::user();

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

        // Cria a cobrança PIX
        $cobranca = $this->asaasService->criarCobranca($customerId, $request->valor, $request->descricao, 'PIX');

        if (!isset($cobranca['id'])) {
            return redirect()->route('pagamento.falhaPix');
        }

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


    // Gera cobrança para pagamento via Boleto
    public function gerarBoleto(Request $request)
    {
        $request->validate([
            'valor' => 'required|numeric',
            'descricao' => 'required|string'
        ]);

        $user = Auth::user();

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

        // Criação da cobrança via boleto
        $cobranca = $this->asaasService->criarCobranca($customerId, $request->valor, $request->descricao, 'BOLETO');

        if (!isset($cobranca['id'])) {
            return redirect()->route('pagamento.falhaBoleto');
        }
        
        // Criação do agendamento
        //obs:
        $horario = Horario::findOrFail(1); // Aqui você pode alterar conforme necessário
        $agendamento = new Agendamento();
        $agendamento->user_id = $user->id;
        $agendamento->horario_id = $horario->id;
        //$agendamento->valor = $request->valor;
        //$agendamento->descricao = $request->descricao;
        $agendamento->status = 'pendente';  // pendente indica aguardando pagamento
        $agendamento->save();

        // Obtém os detalhes do boleto
        $detalhesBoleto = $this->asaasService->obterBoleto($cobranca['id']);

        if (!isset($detalhesBoleto['bankSlipUrl'])) {
            return redirect()->route('pagamento.falhaBoleto');
        }

        // Redireciona para a view de pagamento do boleto
        return view('pagamento/pagamento-boleto', [
            'boletoUrl' => $detalhesBoleto['bankSlipUrl'],
            'valor'     => $request->valor
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


    public function pagamentoBoleto()
    {
        return view('pagamento/pagamento-boleto');
    }

    public function pagamentoPix()
    {
        return view('pagamento/pagamento-pix');
    }

    public function falhaPix()
    {
        return view('pagamento/falha-pix');
    }

    public function falhaBoleto()
    {
        return view('pagamento/falha-boleto');
    }
}
