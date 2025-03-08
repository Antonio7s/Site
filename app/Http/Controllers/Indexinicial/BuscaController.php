<?php

namespace App\Http\Controllers\Indexinicial;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Medico;
use App\Models\Agendamento;
use Carbon\Carbon;

class BuscaController extends Controller
{
    public function Busca(Request $request)
    {
        // Captura os parâmetros da requisição
        $filter = $request->input('filter', 'todos'); // Filtro padrão 'todos'
        $searchTerm = $request->input('query', ''); // Termo de busca

        // Inicia a query; a especialidade está armazenada na coluna "medico_especialidade" da tabela medicos
        $medicosQuery = Medico::with('clinica')->select('medicos.*');

        if (!empty($searchTerm)) {
            if ($filter === 'especialidade') {
                $medicosQuery->where('medico_especialidade', 'like', "%{$searchTerm}%"); // Busca pela especialidade
            } elseif ($filter === 'procedimentos') {
                $medicosQuery->where('procedimentos', 'like', "%{$searchTerm}%");
            } elseif ($filter === 'profissional') {
                $medicosQuery->where(function ($q) use ($searchTerm) {
                    $q->where('profissional_nome', 'like', "%{$searchTerm}%")
                      ->orWhere('profissional_sobrenome', 'like', "%{$searchTerm}%");
                });
            } elseif ($filter === 'clinica') {
                $medicosQuery->whereHas('clinica', function ($query) use ($searchTerm) {
                    $query->where('razao_social', 'like', "%{$searchTerm}%");
                });
            } else { // filtro "todos"
                $medicosQuery->where(function ($q) use ($searchTerm) {
                    $q->where('medico_especialidade', 'like', "%{$searchTerm}%") // Busca pela especialidade
                      ->orWhere('procedimentos', 'like', "%{$searchTerm}%")
                      ->orWhere('profissional_nome', 'like', "%{$searchTerm}%")
                      ->orWhere('profissional_sobrenome', 'like', "%{$searchTerm}%")
                      ->orWhereHas('clinica', function ($query) use ($searchTerm) {
                          $query->where('razao_social', 'like', "%{$searchTerm}%");
                      });
                });
            }
        }

        // Executa a consulta dos médicos
        $medicos = $medicosQuery->get();

        // Se houver termo de busca e nenhum resultado, obtém alguns registros de fallback (ex.: os 5 primeiros)
        $fallbackMedicos = collect();
        if (!empty($searchTerm) && $medicos->isEmpty()) {
            $fallbackMedicos = Medico::with('clinica')->select('medicos.*')->limit(5)->get();
        }

        // Para cada médico, carregamos os agendamentos (usando o model Agendamento)
        foreach ($medicos as $medico) {
            $agendamentos = Agendamento::with('horario')
                ->whereHas('horario.agenda', function ($q) use ($medico) {
                    $q->where('medico_id', $medico->id);
                })
                ->get();

            foreach ($agendamentos as $agendamento) {
                if (
                    $agendamento->horario &&
                    $agendamento->horario->horario_inicio &&
                    isset($agendamento->horario->duracao)
                ) {
                    $duracao = $agendamento->horario->duracao;
                    $slots = [];
                    $startTime = Carbon::parse($agendamento->horario->horario_inicio);
                    // Gera 8 slots incrementando conforme a duração
                    for ($i = 0; $i < 8; $i++) {
                        $slots[] = $startTime->format('H:i');
                        $startTime->addMinutes($duracao);
                    }
                    $agendamento->calculated_slots = $slots;
                } else {
                    $agendamento->calculated_slots = [];
                }
            }
            // Anexa os agendamentos ao objeto médico
            $medico->agendamentos = $agendamentos;
        }

        // Processa fallback medicos de forma semelhante
        foreach ($fallbackMedicos as $medico) {
            $agendamentos = Agendamento::with('horario')
                ->whereHas('horario.agenda', function ($q) use ($medico) {
                    $q->where('medico_id', $medico->id);
                })
                ->get();

            foreach ($agendamentos as $agendamento) {
                if (
                    $agendamento->horario &&
                    $agendamento->horario->horario_inicio &&
                    isset($agendamento->horario->duracao)
                ) {
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

        return view('Busca.Busca', [
            'medicos'         => $medicos,
            'fallbackMedicos' => $fallbackMedicos,
            'searchTerm'      => $searchTerm,
            'filter'          => $filter,
        ]);
    }
}
