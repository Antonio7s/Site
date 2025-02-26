<?php

namespace App\Http\Controllers\Pagamento;

use App\Http\Controllers\Controller;
use App\Models\Horario;
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
                $user->telefone,
                //$user->data_nascimento
            );
            $user->update(['customer_id' => $cliente['id']]);
            $customerId = $cliente['id'];
        } else {
            $customerId = $user->customer_id;
        }

        $cobranca = $this->asaasService->criarCobranca($customerId, $request->valor, $request->descricao, 'PIX');

        return response()->json($cobranca);
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
                $user->telefone,
                //$user->data_nascimento
            );
            $user->update(['customer_id' => $cliente['id']]);
            $customerId = $cliente['id'];
        } else {
            $customerId = $user->customer_id;
        }

        $cobranca = $this->asaasService->criarCobranca($customerId, $request->valor, $request->descricao, 'BOLETO');

        return response()->json($cobranca);
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
}
