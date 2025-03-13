<?php

namespace App\Http\Controllers\Admin_clinica;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Procedimento;
use App\Models\Agendamento;
use App\Models\Classe;
use Carbon\Carbon;
use DB;

class DashboardClinicaController extends Controller
{
    public function index(Request $request)
    {
        // Filtro de período (hoje, semana, mês, personalizado)
        $filter = $request->input('filter', 'hoje'); // Valor padrão: hoje
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');

        // Define o intervalo de datas com base no filtro
        $hoje = Carbon::today();
        switch ($filter) {
            case 'semana':
                $startDate = $hoje->copy()->startOfWeek();
                $endDate = $hoje->copy()->endOfWeek();
                break;
            case 'mes':
                $startDate = $hoje->copy()->startOfMonth();
                $endDate = $hoje->copy()->endOfMonth();
                break;
            case 'custom':
                if ($startDate && $endDate) {
                    $startDate = Carbon::parse($startDate);
                    $endDate = Carbon::parse($endDate);
                } else {
                    // Se não houver datas personalizadas, usa o dia atual
                    $startDate = $hoje;
                    $endDate = $hoje;
                }
                break;
            default: // Hoje
                $startDate = $hoje;
                $endDate = $hoje;
                break;
        }

        // Consulta para "Agendamentos por Categoria":
        // classes(nome) -> procedimento -> horario -> agendamento(somente os que estiverem agendados)
        $vendasPorCategoria = DB::table('classes as c')
            ->join('procedimentos as p', 'c.id', '=', 'p.classe_id')
            ->join('horarios as h', 'p.id', '=', 'h.procedimento_id')
            ->join('agendamentos as ag', 'h.id', '=', 'ag.horario_id')
            ->where('ag.status', '=', 'agendado') // Filtra apenas agendamentos com status "agendado"
            ->whereBetween('ag.data', [$startDate, $endDate]) // Filtra agendamentos no intervalo de datas
            ->select('c.nome as categoria', DB::raw('COUNT(ag.id) as total'))
            ->groupBy('c.nome')
            ->get();

        // Consulta para "Detalhes dos Agendamentos":
        // classes(nome) -> procedimento -> horario -> agendamento(somente os que estiverem agendados)
        $detalhesAgendamentos = DB::table('classes as c')
            ->join('procedimentos as p', 'c.id', '=', 'p.classe_id')
            ->join('horarios as h', 'p.id', '=', 'h.procedimento_id')
            ->join('agendamentos as ag', 'h.id', '=', 'ag.horario_id')
            ->where('ag.status', '=', 'agendado') // Filtra apenas agendamentos com status "agendado"
            ->whereBetween('ag.data', [$startDate, $endDate]) // Filtra agendamentos no intervalo de datas
            ->select(
                'c.nome as classe_nome',
                'p.nome as procedimento_nome',
                'ag.data as data_agendamento'
            )
            ->orderBy('ag.data', 'desc')
            ->limit(10)
            ->get();

        // Retornando a view correta com os dados
        return view('admin-clinica.dashboard.index', [
            'vendasPorCategoria'   => $vendasPorCategoria,
            'detalhesAgendamentos' => $detalhesAgendamentos,
            'hojeStr'              => $hoje->format('Y-m-d'), // Data formatada para exibição
            'filter'               => $filter, // Filtro atual
            'startDate'            => $startDate->format('Y-m-d'), // Data de início formatada
            'endDate'              => $endDate->format('Y-m-d'), // Data de fim formatada
        ]);
    }

    // Endpoint para filtro personalizado (requisição AJAX)
    public function customFilter(Request $request)
    {
        $startDate = $request->input('start');
        $endDate = $request->input('end');

        // Valida as datas
        if (!$startDate || !$endDate) {
            return response()->json(['error' => 'Datas inválidas.'], 400);
        }

        // Define o intervalo de datas
        $startDate = Carbon::parse($startDate);
        $endDate = Carbon::parse($endDate);

        // Consulta para "Agendamentos por Categoria":
        $vendasPorCategoria = DB::table('classes as c')
            ->join('procedimentos as p', 'c.id', '=', 'p.classe_id')
            ->join('horarios as h', 'p.id', '=', 'h.procedimento_id')
            ->join('agendamentos as ag', 'h.id', '=', 'ag.horario_id')
            ->where('ag.status', '=', 'agendado')
            ->whereBetween('ag.data', [$startDate, $endDate])
            ->select('c.nome as categoria', DB::raw('COUNT(ag.id) as total'))
            ->groupBy('c.nome')
            ->get();

        // Consulta para "Detalhes dos Agendamentos":
        $detalhesAgendamentos = DB::table('classes as c')
            ->join('procedimentos as p', 'c.id', '=', 'p.classe_id')
            ->join('horarios as h', 'p.id', '=', 'h.procedimento_id')
            ->join('agendamentos as ag', 'h.id', '=', 'ag.horario_id')
            ->where('ag.status', '=', 'agendado')
            ->whereBetween('ag.data', [$startDate, $endDate])
            ->select(
                'c.nome as classe_nome',
                'p.nome as procedimento_nome',
                'ag.data as data_agendamento'
            )
            ->orderBy('ag.data', 'desc')
            ->limit(10)
            ->get();

        // Retorna os dados em formato JSON
        return response()->json([
            'categoryData' => $vendasPorCategoria,
            'salesData'   => [
                'labels' => $detalhesAgendamentos->pluck('data_agendamento')->map(fn($date) => Carbon::parse($date)->format('d/m/Y')),
                'data'   => $detalhesAgendamentos->pluck('data_agendamento')->map(fn() => 1), // Contagem de agendamentos
            ],
            'dashboardLabel' => "Período Personalizado: {$startDate->format('d/m/Y')} - {$endDate->format('d/m/Y')}",
        ]);
    }
}