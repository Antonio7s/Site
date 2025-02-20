<?php

namespace App\Http\Controllers\Admin_clinica;

use App\Models\Medico;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AgendaController extends Controller
{
    public function index()
    {
        $profissionais = Medico::all();

        return view('/admin-clinica/agenda/index',compact('profissionais'));
    }

    // Método de busca para médicos
    public function search(Request $request)
    {
        // Captura o termo de pesquisa
        $searchTerm = $request->input('searchTerm');

        // Realiza a busca no banco de dados
        $profissionais = Medico::where('profissional_nome', 'LIKE', '%' . $searchTerm . '%')
                        ->orWhere('profissional_sobrenome', 'LIKE', '%' . $searchTerm . '%')
                        ->get();

        // Retorna os médicos encontrados em formato JSON
        return response()->json($profissionais);
    }
}
