<?php

namespace App\Http\Controllers\Admin_clinica;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Clinica; // Importe o modelo Clinica

class AdminClinicaController extends Controller
{
    public function index(Request $request)
    {
        $query = Clinica::query();

        // Verifica se há um termo de busca
        if ($request->filled('search')) {
            $search = $request->search;

            // Filtra os resultados com base no termo de busca
            $query->where(function ($q) use ($search) {
                $q->where('razao_social', 'like', "%{$search}%")
                  ->orWhere('cnpj_cpf', 'like', "%{$search}%")
                  ->orWhere('cidade', 'like', "%{$search}%");
            });
        }

        // Pagina os resultados e anexa os parâmetros da query para manter a busca em todas as páginas
        $clinicas = $query->paginate(30)->appends($request->query());

        // Verifica se a requisição é AJAX
        if ($request->ajax()) {
            return view('admin.sub-diretorios.clinicas.index', compact('clinicas'))->render();
        }

        // Retorna a view com os dados
        return view('admin.sub-diretorios.clinicas.index', compact('clinicas'));
    }
}
