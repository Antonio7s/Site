<?php

namespace App\Http\Controllers\indexinicial;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Medico;

class MedicoController extends Controller
{
    public function index(Request $request)
    {
        // Captura os parâmetros de busca e filtro
        $query = $request->input('query');
        $filter = $request->input('filter');

        // Inicializa a query de médicos
        $medicosQuery = Medico::query();

        // Filtro de busca por nome, especialidade ou clínica
        if ($query) {
            $medicosQuery->where(function ($q) use ($query) {
                $q->where('nome', 'LIKE', "%{$query}%")
                  ->orWhereHas('especialidades', function($q2) use ($query) {
                      $q2->where('nome', 'LIKE', "%{$query}%");
                  })
                  ->orWhereHas('clinicas', function($q3) use ($query) {
                      $q3->where('nome', 'LIKE', "%{$query}%");
                  });
            });
        }

        // Filtro por especialidade (buscando no relacionamento)
        if ($filter) {
            $medicosQuery->whereHas('especialidades', function($q) use ($filter) {
                $q->where('nome', $filter);
            });
        }

        // Obter resultados
        $medicos = $medicosQuery->get();

        // Verificar se há resultados
        $hasResults = $medicos->isNotEmpty();

        return view('busca.busca', [
            'hasResults' => $hasResults, // Passa a variável $hasResults para a view
            'query' => $query,
            'filter' => $filter
        ]);
    }
}