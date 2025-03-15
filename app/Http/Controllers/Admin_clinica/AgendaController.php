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

        // Recupera a agenda do médico (supondo que ele tenha apenas uma)
        $agendaId = $profissional->agenda->id ?? null;

        // Se necessário, verifique se a agenda foi encontrada
        if (!$agendaId) {
            return redirect()->back()->withErrors("Agenda não encontrada para esse médico.");
        }

        return view('/admin-clinica/agenda/horario/create', compact('profissional', 'agendaId'));
    }



    //SALVAR OS HORARIOS NO BD
    public function salvarHorarios(Request $request)
    {
        try {
            $horarios = $request->input('horarios'); // Ex.: array de horários
            
            // Validação básica
            if (!$horarios || !is_array($horarios)) {
                return response()->json(['message' => 'Dados inválidos. O formato esperado é um array de horários.'], 400);
            }
            
            // Loop para salvar os horários
            foreach ($horarios as $horarioData) {
                // Verifica se os dados estão completos
                if (!isset($horarioData['data'], $horarioData['inicio'], $horarioData['duracao'], $horarioData['agenda_id'])) {
                    return response()->json(['message' => 'Dados de horário incompletos.'], 400);
                }
        
                // Certifique-se de que os valores estão no formato correto
                // $horarioInicio = substr($horarioData['inicio'], 0, 5); // Ajuste para garantir que o horário tem o formato correto 'HH:MM'
        

                // Corrige a extração do horário de início
                $horarioInicio = date("H:i", strtotime($horarioData['inicio']));

                //$duracao = intval(str_replace(' minutos', '', $horarioData['duracao'])); // Remover o texto ' minutos' se existir
        
                $duracao = intval(str_replace(' minutos', '', $horarioData['duracao']));


                // Criação do horário no banco de dados
                Horario::create([
                    'data' => $horarioData['data'],  // A data deve ser no formato 'Y-m-d'
                    'horario_inicio' => $horarioInicio,  // O horário de início no formato correto
                    'duracao' => $duracao,  // A duração em minutos
                    'agenda_id' => $horarioData['agenda_id'],  // O ID da agenda
                    'procedimento_id' => $horarioData['procedimento_id'] ?? null,  // O ID do procedimento, se existir
                ]);
            }
        
            return response()->json(['message' => 'Horários salvos com sucesso!'], 200);
        } catch (\Exception $e) {
            // Retorna o erro completo no formato JSON
            return response()->json([
                'message' => 'Erro ao salvar os horários',
                'error' => $e->getMessage(),  // Captura a mensagem do erro
                'trace' => $e->getTraceAsString()  // Captura o trace completo do erro
            ], 500);
        }
    }
    
    




}
