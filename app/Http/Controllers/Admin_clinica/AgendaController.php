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
        $profissionais = Medico::paginate(10);

        return view('/admin-clinica/agenda/index', compact('profissionais'));
    }

    /* Método de busca para médicos
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
    */

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
    
    //Busca todos os profissionais e exibe em listagem


    // 
    public function agendamento_index(Request $request)
    {
        // BUSCA TODOS OS AGENDAMENTO VINCULADO A UM PROFISSIONAL
        //code

        return view('/admin-clinica/agenda/agendamento/index');
    }

    public function agendamento_edit(Request $request)
    {
        return view('/admin-clinica/agenda/agendamento/edit');
    }

    
    /////

    // Método para exibir os horarios
    public function horario_show(Request $request, $medicoId)
    {
        // Busca o médico pelo ID
        $profissional = Medico::findOrFail($medicoId);

        // Busca os horários desse médico, considerando a agenda associada
        $horarios = Horario::with('agenda') // Carregar a relação com 'agenda'
        ->whereHas('agenda', function($query) use ($medicoId) {
            // Filtra apenas horários que pertencem à agenda do médico
            $query->where('medico_id', $medicoId);
        })
        ->get();

        // Retorna a view com os dados do médico e os horários
        return view('admin-clinica.agenda.horario.show', compact('profissional', 'horarios'));
    }

    //
    public function horario_create(Request $request , $medicoId)
    {

        // Verifica se o médico existe
        $profissional = Medico::findOrFail($medicoId); // Encontra o médico pelo ID

        // Busca todas as agendas que o médico pode ter
        $agendas = Agenda::where('medico_id', $medicoId)->get(); // Aqui, é uma suposição de relacionamento, ajuste conforme necessário

        return view('/admin-clinica/agenda/horario/create', compact('profissional', 'agendas'));
    }

    public function salvarHorarios(Request $request)
    {
        $horarios = $request->input('horarios'); // Ex.: array de horários
        // Validação básica (melhor usar FormRequest para regras mais robustas)
        if (!$horarios || !is_array($horarios)) {
            return response()->json(['message' => 'Dados inválidos'], 400);
        }
        
        foreach ($horarios as $horarioData) {
            // Aqui, lembre-se de associar o horário à agenda e procedimento, se necessário.
            Horario::create([
                'data' => $horarioData['data'],
                'horario_inicio' => substr($horarioData['inicio'], 11, 5),
                'duracao' => intval(str_replace(' minutos', '', $horarioData['duracao'])),
                // Exemplo: agenda_id e procedimento_id devem ser enviados ou definidos
                'agenda_id' => $horarioData['agenda_id'] ?? 1, // Ajuste conforme a lógica
                'procedimento_id' => $horarioData['procedimento_id'] ?? 1
            ]);
        }
        return response()->json(['message' => 'Horários salvos com sucesso'], 200);
    }




}
