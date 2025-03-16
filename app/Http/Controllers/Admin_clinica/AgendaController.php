<?php

namespace App\Http\Controllers\Admin_clinica;

use App\Models\Medico;
use App\Models\Agenda;
use App\Models\Agendamento;
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
    public function agendamento_index(Request $request, $medicoId)
    {
        // BUSCA TODOS OS AGENDAMENTO VINCULADO A UM PROFISSIONAL

        // Busca o médico pelo ID
        $profissional = Medico::findOrFail($medicoId);

        // Busca os agendamentos desse médico
        $agendamentos = Agendamento::whereHas('horario.agenda', function ($query) use ($medicoId) {
            $query->where('medico_id', $medicoId);
        })->with(['horario', 'user'])->get();

        return view('/admin-clinica/agenda/agendamento/index', compact('profissional', 'agendamentos'));
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

    public function excluirHorario($id)
    {
        try {
            $horario = Horario::findOrFail($id);

            $horario->delete();
    
            return redirect()->back()
                ->with('success', 'Horário excluído com sucesso!');
    
        } catch (QueryException $e) {
            // Código 23000: violação de integridade referencial (foreign key)
            if ($e->getCode() === '23000') {
                return redirect()->back()
                    ->with('error', 'Erro ao excluir horário: Existem registros vinculados que impedem a exclusão.');
            }
            return redirect()->back()
                ->with('error', 'Erro ao excluir horário: ' . $e->getMessage());
        
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erro ao excluir horário: ' . $e->getMessage());
        }
    }

    //SALVAR OS HORARIOS NO BD
    public function salvarHorarios(Request $request)
    {
        try {
            $horarios = $request->input('horarios');
            
            // Validação básica
            if (!$horarios || !is_array($horarios)) {
                return response()->json([
                    'success' => false, // Adicionado
                    'message' => 'Dados inválidos. O formato esperado é um array de horários.'
                ], 400);
            }
            
            // Loop para salvar os horários
            foreach ($horarios as $horarioData) {
                // Verifica se os dados estão completos
                if (!isset($horarioData['data'], $horarioData['inicio'], $horarioData['duracao'], $horarioData['agenda_id'])) {
                    return response()->json([
                        'success' => false, // Adicionado
                        'message' => 'Dados de horário incompletos.'
                    ], 400);
                }

                // Verificação de duplicidade via código
                $horarioExistente = Horario::where('data', $horarioData['data'])
                    ->where('horario_inicio', date("H:i", strtotime($horarioData['inicio'])))
                    ->where('agenda_id', $horarioData['agenda_id'])
                    ->where('procedimento_id', $horarioData['procedimento_id'] ?? null)
                    ->exists();
            

                if ($horarioExistente) {
                    return response()->json([
                        'success' => false,
                        'message' => "Já existe um horário marcado para $data às $horarioInicio."
                    ], 409); // Código 409 = Conflito
                }
        
                // Criação do horário no banco de dados
                Horario::create([
                    'data' => $horarioData['data'],
                    'horario_inicio' => date("H:i", strtotime($horarioData['inicio'])),
                    'duracao' => intval(str_replace(' minutos', '', $horarioData['duracao'])),
                    'agenda_id' => $horarioData['agenda_id'],
                    'procedimento_id' => $horarioData['procedimento_id'] ?? null,
                ]);
            }
        
            return response()->json([
                'success' => true, // Adicionado
                'message' => 'Horários salvos com sucesso!'
            ]); // Código 200 é padrão
        
        } catch (\Exception $e) {
            return response()->json([
                'success' => false, // Adicionado
                'message' => 'Erro ao salvar os horários',
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ], 500);
        }
    }
    
    




}
