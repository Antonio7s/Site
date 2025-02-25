<?php

namespace App\Http\Controllers\Pagamento;

use App\Services\AsaasService;
use Illuminate\Http\Request;

class PagamentoController extends Controller
{
    protected $asaasService;

    public function __construct(AsaasService $asaasService)
    {
        $this->asaasService = $asaasService;
    }


    public function index(){
        return view('pagamento/checkout');
    }

    public function criarCobrancaPix(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|string',
            'valor' => 'required|numeric',
            'descricao' => 'required|string',
        ]);

        $cobranca = $this->asaasService->criarCobranca(
            $request->customer_id,
            $request->valor,
            $request->descricao
        );

        return response()->json($cobranca);
    }
    
    public function criarCobrancaBoleto(Request $request)
    {
        //code
    }

    public function criarCobrancaCartao(Request $request)
    {
        //code
    }

    public function realizarPagamentoPix(Request $request)
    {
        //code
    }

}
