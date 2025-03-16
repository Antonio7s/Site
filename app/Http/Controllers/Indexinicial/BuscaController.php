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
        $filter = $request->input('filter', 'todos');
        $searchTerm = $request->input('query', '');

        // Inicia a query com todos os médicos
        $medicosQuery = Medico::with('clinica')->select('medicos.*');

        // Aplica o filtro conforme o valor selecionado
        if (!empty($searchTerm)) {
            switch ($filter) {
                case 'especialidade':
                    $medicosQuery->where(function($query) use ($searchTerm) {
                        $query->where('medico_especialidade', 'like', "%{$searchTerm}%")
                              ->orWhere('medico_especialidade2', 'like', "%{$searchTerm}%");
                    });
                    break;
                case 'localizacao':
                    $medicosQuery->whereHas('clinica', function ($query) use ($searchTerm) {
                        $query->where('endereco', 'like', "%{$searchTerm}%");
                    });
                    break;
                case 'profissional':
                    $medicosQuery->where(function($query) use ($searchTerm) {
                        $query->where(DB::raw("CONCAT(profissional_nome, ' ', profissional_sobrenome)"), 'like', "%{$searchTerm}%")
                              ->orWhere('profissional_nome', 'like', "%{$searchTerm}%")
                              ->orWhere('profissional_sobrenome', 'like', "%{$searchTerm}%");
                    });
                    break;
                case 'clinica':
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
            $this->attachHorarios($medico);
            $this->formatMedico($medico);
        }
        foreach ($fallbackMedicos as $medico) {
            $this->attachHorarios($medico);
            $this->formatMedico($medico);
        }

        return view('Busca.Busca', [
            'medicos'         => $medicos,
            'fallbackMedicos' => $fallbackMedicos,
            'searchTerm'      => $searchTerm,
            'filter'          => $filter,
        ]);
    }

    private function attachHorarios($medico)
    {
        // 1. Buscar todos os horários do médico com especialidade e valor
        $horarios = DB::table('horarios')
            ->join('agendas', 'agendas.id', '=', 'horarios.agenda_id')
            ->join('procedimentos', 'procedimentos.id', '=', 'horarios.procedimento_id')
            ->leftJoin('agendamentos', function ($join) {
                $join->on('horarios.id', '=', 'agendamentos.horario_id')
                     ->where('agendamentos.status', 'agendado');
            })
            ->where('agendas.medico_id', $medico->id)
            ->select(
                'horarios.id as horario_id',
                'horarios.horario_inicio',
                'procedimentos.nome as especialidade',
                'procedimentos.valor',
                'agendamentos.id as agendamento_id'
            )
            ->get();

        // 2. Filtrar apenas os horários que **não** estão agendados
        $horariosDisponiveis = $horarios->filter(function ($horario) {
            return is_null($horario->agendamento_id);
        });

        // 3. Pegar a primeira especialidade e valor (independentemente de ter agendado ou não)
        $especialidade = $horarios->first()->especialidade ?? '--';
        $valor = $horarios->first()->valor ?? '--';

        // 4. Atribuir ao médico
        $medico->horarios_disponiveis = $horariosDisponiveis;
        $medico->especialidade = $especialidade;
        $medico->valor = $valor;
    }

    private function formatMedico($medico)
    {
        $medico->nome_completo = trim($medico->profissional_nome . ' ' . $medico->profissional_sobrenome);

        if ($medico->clinica) {
            $medico->clinica_nome = $medico->clinica->nome_fantasia;
            $medico->latitude = $medico->clinica->latitude;
            $medico->longitude = $medico->clinica->longitude;
            $medico->endereco = $medico->clinica->endereco;
        } else {
            $medico->clinica_nome = 'Clínica não informada';
            $medico->latitude = null;
            $medico->longitude = null;
            $medico->endereco = '--';
        }

        // Adição do campo de foto se existir na tabela medicos
        $medico->foto = !empty($medico->foto_url) ? $medico->foto_url : null;

        return $medico;
    }
}
