<?php

namespace App\Http\Controllers\Admin_clinica;

use App\Models\ServicoDiferenciado;
use App\Models\Procedimento;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ServicosController extends Controller
{
    public function index()
    {
        // Obtém a clínica autenticada (assumindo que a autenticação é por usuário)
        $clinica = auth()->user(); // Aqui estamos assumindo que a clínica autenticada é um usuário.

        // Carrega todos os procedimentos
        $procedimentos = Procedimento::all();

        // Para cada procedimento, verifica se existe um serviço diferenciado
        $servicos = $procedimentos->map(function ($procedimento) use ($clinica) {
            // Tenta encontrar o serviço diferenciado vinculado à clínica e ao procedimento
            $servico = $clinica->servicosDiferenciados->firstWhere('procedimento_id', $procedimento->id);

            // Se houver serviço diferenciado, retorna ele. Caso contrário, retorna o procedimento padrão
            return $servico ?: $procedimento;
        });

        // Passa os serviços (ou procedimentos) para a view
        return view('admin-clinica.servicos.index', compact('clinica', 'servicos'));
    }
}

