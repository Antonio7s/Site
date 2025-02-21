<?php

namespace App\Http\Controllers\Admin_clinica;

use App\Models\Medico;
use App\Models\Agenda;
use App\Models\Horario;


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

    // Método para obter a agenda de um profissional
    public function getAgenda(Request $request)
    {
        $profissionalId = $request->get('profissionalId');
        
        // Busca a agenda do profissional
        $agenda = Agenda::where('medico_id', $profissionalId)->first(); // Ajuste de acordo com seu modelo e relacionamento
        
        if ($agenda) {
            return response()->json($agenda); // Retorna a agenda
        } else {
            return response()->json(['message' => 'Agenda não encontrada'], 404);
        }
    }
    

    // Método para 
    public function agendamento_create(Request $request)
    {
        return view('/admin-clinica/agenda/agendamento/create');
    }

    //
    public function horario_create(Request $request)
    {
        return view('/admin-clinica/agenda/horario/create');
    }

    // Método para 
    public function agendamento_index(Request $request)
    {
        return view('/admin-clinica/agenda/agendamento/show');
    }

    // Método para 
    public function horario_index(Request $request)
    {
        return view('/admin-clinica/agenda/horario/index');
    }
}
