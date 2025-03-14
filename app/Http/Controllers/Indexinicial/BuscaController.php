<?php
namespace App\Http\Controllers\Indexinicial;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Medico;
use App\Models\Agendamento;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class BuscaController extends Controller
{
    public function Busca(Request $request)
    {
        $filter = $request->input('filter', 'todos');
        $searchTerm = $request->input('query', '');

        // Inicia a query com todos os médicos
        $medicosQuery = Medico::with('clinica')->select('medicos.*');

        // Aplica o filtro conforme o valor selecionado
        if (!empty($searchTerm)) {
            switch ($filter) {
                case 'especialidade':
                    // Busca em ambos os campos de especialidade
                    $medicosQuery->where(function($query) use ($searchTerm) {
                        $query->where('medico_especialidade', 'like', "%{$searchTerm}%")
                              ->orWhere('medico_especialidade2', 'like', "%{$searchTerm}%");
                    });
                    break;
                case 'localizacao':
                    // Busca no campo 'endereco' da clínica
                    $medicosQuery->whereHas('clinica', function ($query) use ($searchTerm) {
                        $query->where('endereco', 'like', "%{$searchTerm}%");
                    });
                    break;
                case 'profissional':
                    // Busca no nome completo do profissional
                    $medicosQuery->where(function($query) use ($searchTerm) {
                        $query->where(DB::raw("CONCAT(profissional_nome, ' ', profissional_sobrenome)"), 'like', "%{$searchTerm}%")
                              ->orWhere('profissional_nome', 'like', "%{$searchTerm}%")
                              ->orWhere('profissional_sobrenome', 'like', "%{$searchTerm}%");
                    });
                    break;
                case 'clinica':
                    // Busca no nome da clínica (razao_social)
                    $medicosQuery->whereHas('clinica', function ($query) use ($searchTerm) {
                        $query->where('razao_social', 'like', "%{$searchTerm}%");
                    });
                    break;
                default: // 'todos'
                    $medicosQuery->where(function ($q) use ($searchTerm) {
                        $q->where('medico_especialidade', 'like', "%{$searchTerm}%")
                          ->orWhere('medico_especialidade2', 'like', "%{$searchTerm}%")
                          ->orWhereExists(function ($query) use ($searchTerm) {
                              $query->select(DB::raw(1))
                                    ->from('agendamentos')
                                    ->join('horarios', 'horarios.id', '=', 'agendamentos.horario_id')
                                    ->join('procedimentos', 'procedimentos.id', '=', 'horarios.procedimento_id')
                                    ->join('agendas', 'agendas.id', '=', 'horarios.agenda_id')
                                    ->whereRaw('agendas.medico_id = medicos.id')
                                    ->where('procedimentos.nome', 'like', "%{$searchTerm}%");
                          })
                          ->orWhereHas('clinica', function ($query) use ($searchTerm) {
                              $query->where('endereco', 'like', "%{$searchTerm}%");
                          })
                          ->orWhere(function($query) use ($searchTerm) {
                              $query->where(DB::raw("CONCAT(profissional_nome, ' ', profissional_sobrenome)"), 'like', "%{$searchTerm}%")
                                    ->orWhere('profissional_nome', 'like', "%{$searchTerm}%")
                                    ->orWhere('profissional_sobrenome', 'like', "%{$searchTerm}%");
                          })
                          ->orWhereHas('clinica', function ($query) use ($searchTerm) {
                              $query->where('razao_social', 'like', "%{$searchTerm}%");
                          });
                    });
                    break;
            }
        }

        // Paginação para limitar a 7 médicos por página
        $medicos = $medicosQuery->paginate(7);

        // Se não houver resultados, exibe 22 médicos como fallback
        $fallbackMedicos = collect();
        if ($medicos->isEmpty()) {
            $fallbackMedicos = Medico::with('clinica')->select('medicos.*')->limit(22)->get();
        }

        // Processa agendamentos e formata os dados
        foreach ($medicos as $medico) {
            $this->attachAgendamentos($medico);
            $this->formatMedico($medico);
        }
        foreach ($fallbackMedicos as $medico) {
            $this->attachAgendamentos($medico);
            $this->formatMedico($medico);
        }

        return view('Busca.Busca', [
            'medicos'         => $medicos,
            'fallbackMedicos' => $fallbackMedicos,
            'searchTerm'      => $searchTerm,
            'filter'          => $filter,
        ]);
    }

    private function attachAgendamentos($medico)
    {
        $agendamentos = Agendamento::with(['horario', 'horario.procedimento'])
            ->whereHas('horario.agenda', function ($q) use ($medico) {
                $q->where('medico_id', $medico->id);
            })
            ->get();

        foreach ($agendamentos as $agendamento) {
            if ($agendamento->horario && $agendamento->horario->horario_inicio && isset($agendamento->horario->duracao)) {
                $duracao = $agendamento->horario->duracao;
                $slots = [];
                $startTime = Carbon::parse($agendamento->horario->horario_inicio);
                for ($i = 0; $i < 8; $i++) {
                    $slots[] = $startTime->format('H:i');
                    $startTime->addMinutes($duracao);
                }
                $agendamento->calculated_slots = $slots;
            } else {
                $agendamento->calculated_slots = [];
            }
        }
        $medico->agendamentos = $agendamentos;
    }

    private function formatMedico($medico)
    {
        $medico->nome_completo = trim($medico->profissional_nome . ' ' . $medico->profissional_sobrenome);

        // Obtém o nome e valor do procedimento, se houver
        $procedureName = null;
        $procedureValor = null;
        if ($medico->agendamentos && $medico->agendamentos->isNotEmpty()) {
            foreach ($medico->agendamentos as $agendamento) {
                if ($agendamento->horario && $agendamento->horario->procedimento) {
                    $procedureName = $agendamento->horario->procedimento->nome;
                    $procedureValor = $agendamento->horario->procedimento->valor ?? '--';
                    break;
                }
            }
        }

        // Se o campo medico_especialidade estiver preenchido, ele terá prioridade.
        // Se existir uma segunda especialidade (medico_especialidade2), ambas serão exibidas.
        if (!empty($medico->medico_especialidade) || !empty($medico->medico_especialidade2)) {
            $especialidades = [];
            if (!empty($medico->medico_especialidade)) {
                $especialidades[] = $medico->medico_especialidade;
            }
            if (!empty($medico->medico_especialidade2)) {
                $especialidades[] = $medico->medico_especialidade2;
            }
            $medico->especialidade = implode(', ', $especialidades);
        } else {
            $medico->especialidade = $procedureName ? $procedureName : '--';
        }
        $medico->valor = $procedureValor ? $procedureValor : '--';

        if ($medico->clinica) {
            $medico->clinica_nome = $medico->clinica->nome_fantasia;
            $medico->latitude = $medico->clinica->latitude;
            $medico->longitude = $medico->clinica->longitude;
        } else {
            $medico->clinica_nome = 'Clínica não informada';
            $medico->latitude = null;
            $medico->longitude = null;
        }

        $medico->endereco = '--';

        return $medico;
    }
}
