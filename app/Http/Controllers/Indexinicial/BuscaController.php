<?php

namespace App\Http\Controllers\Indexinicial;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Medico;
use App\Models\ServicoDiferenciado;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BuscaController extends Controller
{
    public function Busca(Request $request)
    {
        $filter = $request->input('filter', 'todos');
        $searchTerm = $request->input('query', '');

        // Query base para médicos
        $medicosQuery = Medico::with('clinica')->select('medicos.*');

        // Aplicação dos filtros
        if (!empty($searchTerm)) {
            switch ($filter) {
                case 'especialidade':
                    $medicosQuery->where(function($query) use ($searchTerm) {
                        $query->where('especialidade', 'like', "%{$searchTerm}%")
                              ->orWhere('especialidade2', 'like', "%{$searchTerm}%");
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
                        $q->where('especialidade', 'like', "%{$searchTerm}%")
                          ->orWhere('especialidade2', 'like', "%{$searchTerm}%")
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

        // Paginação e fallback
        $medicos = $medicosQuery->paginate(7);
        if ($medicos->isEmpty()) {
            $medicos = Medico::with('clinica')->select('medicos.*')->limit(22)->get();
        }

        // Processamento dos médicos
        foreach ($medicos as $medico) {
            $this->attachHorarios($medico);
            $this->formatMedico($medico);
        }

        return view('busca.busca', [
            'medicos'    => $medicos,
            'searchTerm' => $searchTerm,
            'filter'     => $filter,
        ]);
    }

    private function attachHorarios($medico)
    {
        // Query modificada com serviços diferenciados
        $horarios = DB::table('horarios')
            ->join('agendas', 'agendas.id', '=', 'horarios.agenda_id')
            ->join('procedimentos', 'procedimentos.id', '=', 'horarios.procedimento_id')
            ->leftJoin('servico_diferenciados', function($join) use ($medico) {
                $join->on('procedimentos.id', '=', 'servico_diferenciados.procedimento_id')
                     ->where('servico_diferenciados.clinica_id', '=', optional($medico->clinica)->id)
                     ->whereDate('servico_diferenciados.data_inicial', '<=', Carbon::today())
                     ->whereDate('servico_diferenciados.data_final', '>=', Carbon::today());
            })
            ->leftJoin('agendamentos', function ($join) {
                $join->on('horarios.id', '=', 'agendamentos.horario_id')
                     ->where('agendamentos.status', 'agendado');
            })
            ->where('agendas.medico_id', $medico->id)
            ->orderBy('horarios.horario_inicio', 'asc')
            ->select(
                'horarios.id as horario_id',
                'horarios.horario_inicio',
                'horarios.data',
                'procedimentos.nome as especialidade',
                DB::raw('COALESCE(servico_diferenciados.preco_customizado, procedimentos.valor) as valor'),
                'agendamentos.id as agendamento_id'
            )
            ->get();

        // Processamento dos horários
        $horarios->transform(function ($horario) {
            return (object)[
                'horario_id' => $horario->horario_id,
                'horario_inicio' => $horario->horario_inicio,
                'data' => $horario->data,
                'especialidade' => $horario->especialidade,
                'valor' => $horario->valor,
                'bloqueado' => !is_null($horario->agendamento_id)
            ];
        });

        // Atribuição ao médico
        $medico->horarios = $horarios;
        $medico->especialidade = $horarios->isNotEmpty() ? $horarios->first()->especialidade : '--';
        $medico->valor = $horarios->isNotEmpty() ? $horarios->first()->valor : '--';
    }

    private function formatMedico($medico)
    {
        // Formatação dos dados
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

        $medico->foto = $medico->foto_url 
            ? asset('storage/' . $medico->foto_url) 
            : asset('images/default-avatar.png');

        return $medico;
    }
}