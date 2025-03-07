<?php

namespace App\Http\Controllers\Indexinicial;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Medico;
use Illuminate\Support\Facades\DB;

class BuscaController extends Controller
{
    public function Busca(Request $request)
    {
        // Captura os parâmetros da requisição
        $filter = $request->input('filter', 'todos'); // Filtro padrão 'todos'
        $searchTerm = $request->input('query', ''); // Termo de busca

        // Inicia a query incluindo a relação com a clínica
        $medicosQuery = Medico::with('clinica');

        if (!empty($searchTerm)) {
            if ($filter === 'especialidade') {
                $medicosQuery->where('especialidade', 'like', "%{$searchTerm}%");
            } elseif ($filter === 'procedimentos') {
                $medicosQuery->where('procedimentos', 'like', "%{$searchTerm}%");
            } elseif ($filter === 'profissional') {
                $medicosQuery->where(function ($q) use ($searchTerm) {
                    $q->where('profissional_nome', 'like', "%{$searchTerm}%")
                      ->orWhere('profissional_sobrenome', 'like', "%{$searchTerm}%");
                });
            } elseif ($filter === 'clinica') {
                $medicosQuery->whereHas('clinica', function ($query) use ($searchTerm) {
                    $query->where('razao_social', 'like', "%{$searchTerm}%");
                });
            } else { // filtro 'todos'
                $medicosQuery->where(function ($q) use ($searchTerm) {
                    $q->where('especialidade', 'like', "%{$searchTerm}%")
                      ->orWhere('procedimentos', 'like', "%{$searchTerm}%")
                      ->orWhere('profissional_nome', 'like', "%{$searchTerm}%")
                      ->orWhere('profissional_sobrenome', 'like', "%{$searchTerm}%")
                      ->orWhereHas('clinica', function ($query) use ($searchTerm) {
                          $query->where('razao_social', 'like', "%{$searchTerm}%");
                      });
                });
            }
        }

        // Executa a consulta (se não houver termo de busca, retorna todos)
        $medicos = $medicosQuery->get();

        // Caso haja termo de busca e nenhum resultado, obtemos alguns registros de fallback (ex.: os 5 primeiros)
        $fallbackMedicos = collect();
        if (!empty($searchTerm) && $medicos->isEmpty()) {
            $fallbackMedicos = Medico::with('clinica')->limit(5)->get();
        }

        return view('Busca.Busca', [
            'medicos'         => $medicos,
            'fallbackMedicos' => $fallbackMedicos,
            'searchTerm'      => $searchTerm,
            'filter'          => $filter,
        ]);
    }
}
