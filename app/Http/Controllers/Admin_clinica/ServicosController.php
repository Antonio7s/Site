<?php

namespace App\Http\Controllers\Admin_clinica;

use App\Models\ServicoDiferenciado;
use App\Models\Procedimento;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log; //  logs para depuracao

class ServicosController extends Controller
{
    public function index()
    {
        // Obtém a clínica autenticada (assumindo que a autenticação é por usuário)
        $clinica = auth()->user(); // Aqui estamos assumindo que a clínica autenticada é um usuário.

        // Carrega todos os procedimentos
        $procedimentos = Procedimento::all();

        // Data atual
        $dataAtual = Carbon::now();

        // Para cada procedimento, verifica se existe um serviço diferenciado dentro do intervalo de datas
        $servicos = $procedimentos->map(function ($procedimento) use ($clinica, $dataAtual) {
            // Tenta encontrar o serviço diferenciado vinculado à clínica e ao procedimento
            $servico = $clinica->servicosDiferenciados
                ->firstWhere('procedimento_id', $procedimento->id);

                if ($servico) {
                    // Convertendo datas
                    $dataInicial = Carbon::parse($servico->data_inicial);
                    $dataFinal = Carbon::parse($servico->data_final);
            
                    // Log para verificar as datas
                    Log::info("Data Atual: {$dataAtual}");
                    Log::info("Data Inicial: {$dataInicial}");
                    Log::info("Data Final: {$dataFinal}");
            
                    // Comparação corrigida
                    if ($dataAtual->gte($dataInicial) && $dataAtual->lte($dataFinal)) {
                        Log::info("Serviço Diferenciado Exibido: " . json_encode($servico));
                        return $servico;
                    }
                }
            
                Log::info("Procedimento Padrão Exibido: " . json_encode($procedimento));
                return $procedimento;
        });

        // Passa os serviços (ou procedimentos) para a view
        return view('admin-clinica.servicos.index', compact('clinica', 'servicos'));
    }
}

