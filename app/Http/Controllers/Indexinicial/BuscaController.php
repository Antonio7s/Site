<?php

namespace App\Http\Controllers\Indexinicial;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Medico;
use Illuminate\Support\Facades\DB;
use App\Models\ServicoDiferenciado;
use Carbon\Carbon;

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

        // Paginação para limitar a 7 médicos por página
        $medicos = $medicosQuery->paginate(7);

        // Se não houver resultados, exibe 22 médicos como fallback
        if ($medicos->isEmpty()) {
            $medicos = Medico::with('clinica')->select('medicos.*')->limit(22)->get();
        }

        // Processa agendamentos (slots) e formata os dados
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
        // Busca todos os horários do médico, sem excluir os agendados
        $horarios = DB::table('horarios')
            ->join('agendas', 'agendas.id', '=', 'horarios.agenda_id')
            ->join('procedimentos', 'procedimentos.id', '=', 'horarios.procedimento_id')
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
                'procedimentos.valor',
                'agendamentos.id as agendamento_id'
            )
            ->get();

        // Para cada horário, adiciona a flag 'bloqueado' se existir um agendamento com status "agendado"
        $horarios->transform(function ($horario) {
            $horario->bloqueado = !is_null($horario->agendamento_id);
            return $horario;
        });

        // Define a especialidade e o valor com base no primeiro slot (se existir)
        if ($horarios->isNotEmpty()) {
            $especialidade = $horarios->first()->especialidade;
            $valor = $horarios->first()->valor;
        } else {
            $especialidade = '--';
            $valor = '--';
        }

        // Atribui todos os horários (com a flag) ao médico
        $medico->horarios = $horarios;
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

        // CORREÇÃO SOLICITADA: Busca a foto diretamente da coluna foto_url da tabela medicos
        $medico->foto = $medico->foto_url ? asset('storage/' . $medico->foto_url) : null;

        return $medico;
    }
}