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
        $filter = $request->input('filter', 'todos');
        $searchTerm = $request->input('query', '');

        // Inicia a query com o relacionamento com a clínica
        $medicosQuery = Medico::with('clinica')->select('medicos.*');

        if (!empty($searchTerm)) {
            if ($filter === 'especialidade') {
                $medicosQuery->where('medico_especialidade', 'like', "%{$searchTerm}%");
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
            } else {
                $medicosQuery->where(function ($q) use ($searchTerm) {
                    $q->where('medico_especialidade', 'like', "%{$searchTerm}%")
                      ->orWhere('procedimentos', 'like', "%{$searchTerm}%")
                      ->orWhere('profissional_nome', 'like', "%{$searchTerm}%")
                      ->orWhere('profissional_sobrenome', 'like', "%{$searchTerm}%")
                      ->orWhereHas('clinica', function ($query) use ($searchTerm) {
                          $query->where('razao_social', 'like', "%{$searchTerm}%");
                      });
                });
            }
        }

        $medicos = $medicosQuery->get();

        // Se não houver resultados, usa fallback
        $fallbackMedicos = collect();
        if (!empty($searchTerm) && $medicos->isEmpty()) {
            $fallbackMedicos = Medico::with('clinica')->select('medicos.*')->limit(5)->get();
        }

        // Para cada médico, anexa os agendamentos (caso existam) e formata os dados
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

    /**
     * Anexa os agendamentos do médico e gera os slots calculados.
     */
    private function attachAgendamentos($medico)
    {
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

    /**
     * Formata os dados do médico para exibição, seguindo o mesmo caminho dos meusPedidos.
     * - "Especialidade": exibe o conteúdo da chave "procedimentos" do JSON do campo procedimentos ou "--".
     * - "Valor": exibe o valor presente na chave "valor" do JSON ou "--".
     * - "Clínica": exibe o nome da clínica associada.
     * - "Endereço": fixo como "--".
     * - "Localização": utiliza os dados da clínica (latitude/longitude) para o link "Ver no Mapa".
     */
    private function formatMedico($medico)
    {
        // Nome completo
        $medico->nome_completo = trim($medico->profissional_nome . ' ' . $medico->profissional_sobrenome);

        // "Especialidade" e "Valor" a partir do campo procedimentos (JSON)
        if (!empty($medico->procedimentos)) {
            $procedimentoData = json_decode($medico->procedimentos, true);
            $medico->especialidade = isset($procedimentoData['procedimentos']) ? $procedimentoData['procedimentos'] : '--';
            $medico->valor = isset($procedimentoData['valor']) ? $procedimentoData['valor'] : '--';
        } else {
            $medico->especialidade = '--';
            $medico->valor = '--';
        }

        // "Clínica": pelo relacionamento
        if ($medico->clinica) {
            $medico->clinica_nome = $medico->clinica->razao_social;
            $medico->latitude = $medico->clinica->latitude;
            $medico->longitude = $medico->clinica->longitude;
        } else {
            $medico->clinica_nome = 'Clínica não informada';
            $medico->latitude = null;
            $medico->longitude = null;
        }

        // "Endereço": fixo
        $medico->endereco = '--';

        return $medico;
    }
}
