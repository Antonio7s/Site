<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Agendamento;
use App\Models\User;
use App\Models\Clinica;
use App\Models\Agenda;
use App\Models\Horario;
use App\Models\Procedimento;
use App\Models\Classe;
use DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalVendas   = Classe::join('procedimentos as p', 'classes.id', '=', 'p.classe_id')
            ->join('horarios as h', 'p.id', '=', 'h.procedimento_id')
            ->join('agendamentos as ag', 'h.id', '=', 'ag.horario_id')
            ->count() ?? 0;
        
        $totalUsuarios = User::count() ?? 0; 
        $totalClinicas = Clinica::count() ?? 0;
        
        // Dados para os cards extras
        $totalClasses = Classe::count() ?? 0;
        
        $totalProcedimentos = Procedimento::count() ?? 0;
        $totalHorarios      = Horario::count() ?? 0;
        $totalAgendamentos  = Agendamento::count() ?? 0;

        $usuarios = User::latest()->limit(10)->get() ?? collect([]);
        $clinicas = Clinica::latest()->limit(10)->get() ?? collect([]);

        // Verifica o driver para usar a função correta de formatação da data
        $driver = DB::connection()->getDriverName();
        $monthExpression = $driver === 'mysql'
            ? "DATE_FORMAT(created_at, '%m')"
            : "strftime('%m', created_at)";
        $dateExpression = $driver === 'mysql'
            ? "DATE_FORMAT(created_at, '%Y-%m-%d')"
            : "strftime('%Y-%m-%d', created_at)";

        $vendasMensais = Agendamento::select(
                DB::raw("$monthExpression as mes"),
                DB::raw('COUNT(id) as total')
            )
            ->groupBy(DB::raw("$monthExpression"))
            ->pluck('total', 'mes')
            ->toArray();

        // Consulta para o gráfico "Distribuição de Vendas por Categoria"
        $vendasPorCategoria = DB::table('classes as c')
            ->join('procedimentos as p', 'c.id', '=', 'p.classe_id')
            ->join('horarios as h', 'p.id', '=', 'h.procedimento_id')
            ->join('agendamentos as ag', 'h.id', '=', 'ag.horario_id')
            ->where('ag.status', '=', 'agendado')
            ->select('c.nome as categoria', DB::raw('COUNT(ag.id) as total'))
            ->groupBy('c.nome')
            ->get();

        // Consulta para o Crescimento de Vendas
        $crescimentoVendas = Agendamento::select(
                DB::raw("$dateExpression as data"),
                DB::raw('COUNT(id) as total')
            )
            ->groupBy(DB::raw("$dateExpression"))
            ->orderBy('data', 'asc')
            ->get();

        // Consulta para Últimas Vendas
        $ultimasVendas = DB::table('classes as c')
            ->join('procedimentos as p', 'c.id', '=', 'p.classe_id')
            ->join('horarios as h', 'p.id', '=', 'h.procedimento_id')
            ->join('agendamentos as ag', 'h.id', '=', 'ag.horario_id')
            ->select('c.id as classe_id', 'c.nome as classe_nome', 'p.id as procedimento_id', 'h.id as horario_id', 'ag.id as agendamento_id', 'ag.created_at as data_agendamento')
            ->orderBy('ag.created_at', 'desc')
            ->limit(10)
            ->get();

        return view('admin.sub-diretorios.dashboard.vendas', [
            'totalVendas'        => $totalVendas,
            'totalUsuarios'      => $totalUsuarios, 
            'totalClinicas'      => $totalClinicas,
            'totalClasses'       => $totalClasses,
            'totalProcedimentos' => $totalProcedimentos,
            'totalHorarios'      => $totalHorarios,
            'totalAgendamentos'  => $totalAgendamentos,
            'usuarios'           => $usuarios, 
            'clinicas'           => $clinicas,
            'vendasMensais'      => $vendasMensais,
            'vendasPorCategoria' => $vendasPorCategoria,
            'crescimentoVendas'  => $crescimentoVendas,
            'ultimasVendas'      => $ultimasVendas,
        ]);
    }
}
