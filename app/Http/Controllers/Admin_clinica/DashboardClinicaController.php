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
        // Agrupa os agendamentos com status "agendado" por categoria (classe) e conta o número de registros
        $vendasPorCategoria = DB::table('classes as c')
            ->join('procedimentos as p', 'c.id', '=', 'p.classe_id')
            ->join('horarios as h', 'p.id', '=', 'h.procedimento_id')
            ->join('agendamentos as ag', 'h.id', '=', 'ag.horario_id')
            ->where('ag.status', '=', 'agendado') // Filtra apenas agendamentos com status "agendado"
            ->whereBetween('ag.data', [$startDate, $endDate]) // Filtra agendamentos no intervalo de datas
            ->select('c.nome as categoria', DB::raw('COUNT(ag.id) as total'))
            ->groupBy('c.nome')
            ->get();

        // Consulta para "Vendas / Agendamentos por Período":
        // Busca os registros detalhados dos agendamentos com status "agendado" e informações da classe, procedimento, horário e data do agendamento
        $detalhesAgendamentos = DB::table('classes as c')
            ->join('procedimentos as p', 'c.id', '=', 'p.classe_id')
            ->join('horarios as h', 'p.id', '=', 'h.procedimento_id')
            ->join('agendamentos as ag', 'h.id', '=', 'ag.horario_id')
            ->where('ag.status', '=', 'agendado') // Filtra apenas agendamentos com status "agendado"
            ->whereBetween('ag.data', [$startDate, $endDate]) // Filtra agendamentos no intervalo de datas
            ->select(
                'c.id as classe_id',
                'c.nome as classe_nome',
                'p.id as procedimento_id',
                'p.nome as procedimento_nome',
                'h.id as horario_id',
                'ag.id as agendamento_id',
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

        // Consulta para "Vendas / Agendamentos por Período":
        $detalhesAgendamentos = DB::table('classes as c')
            ->join('procedimentos as p', 'c.id', '=', 'p.classe_id')
            ->join('horarios as h', 'p.id', '=', 'h.procedimento_id')
            ->join('agendamentos as ag', 'h.id', '=', 'ag.horario_id')
            ->where('ag.status', '=', 'agendado')
            ->whereBetween('ag.data', [$startDate, $endDate])
            ->select(
                'c.id as classe_id',
                'c.nome as classe_nome',
                'p.id as procedimento_id',
                'p.nome as procedimento_nome',
                'h.id as horario_id',
                'ag.id as agendamento_id',
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
                'data'   => $detalhesAgendamentos->pluck('agendamento_id')->map(fn() => 1),
            ],
            'dashboardLabel' => "Período Personalizado: {$startDate->format('d/m/Y')} - {$endDate->format('d/m/Y')}",
        ]);
    }
}
