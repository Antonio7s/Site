<?php

namespace App\Http\Controllers\Pagamento;

//models
use App\Models\Horario;
use App\Models\User;
use App\Models\Agenda;
use App\Models\Medico;
use App\Models\Clinica;
use App\Models\Procedimento;

use App\Http\Controllers\Controller;

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

        
        //Pegando o primeiro horario
        $horario = Horario::findOrFail(1);
        
        //informacoes do user autenticado
        $user = 
        
        // Pegando a agenda relacionada ao horário
        $agenda = $horario->agenda;
        $medico = $horario->agenda->medico;
        $clinica = $horario->agenda->medico->clinica;
        $procedimento = $horario->procedimento;
        return view('pagamento.checkout', compact('horario', 'agenda', 'clinica', 'medico','procedimento'));
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
