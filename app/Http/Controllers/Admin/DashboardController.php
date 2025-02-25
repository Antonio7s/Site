<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Agendamento;
use App\Models\User;
use App\Models\Clinica;
use App\Models\Agenda;
use App\Models\Horario;
use App\Models\Procedimento; // Adicionado o modelo Procedimento

class DashboardController extends Controller
{
    public function index()
    {
        $totalVendas   = Agendamento::count() ?? 0; 
        $totalUsuarios = User::count() ?? 0; 
        $totalClinicas = Clinica::count() ?? 0;
        
        // Novos dados para os cards extras
        $totalClasses       = Agenda::count() ?? 0;
        $totalProcedimentos = Procedimento::count() ?? 0; // Corrigido para usar o modelo Procedimento
        $totalHorarios      = Horario::count() ?? 0;
        $totalAgendamentos  = $totalVendas; // Mesmo valor de $totalVendas

        // Carrega 'horario' e 'user'
        $vendas = Agendamento::with([
            'horario',
            'user'
        ])->latest()->limit(10)->get() ?? collect([]);

        // Coleta os IDs de horários dos agendamentos
        $horarioIds = $vendas->pluck('horario.id')->filter()->unique();

        // Consulta todas as agendas associadas aos horários carregados,
        // com seus relacionamentos 'medico.clinica'
        $agendasGrouped = Agenda::with('medico.clinica')
            ->whereIn('horario_id', $horarioIds)
            ->get()
            ->groupBy('horario_id');

        // Para cada agendamento, associamos a coleção de agendas ao Horário
        $vendas->each(function ($venda) use ($agendasGrouped) {
            if ($venda->horario) {
                $agendas = $agendasGrouped->get($venda->horario->id, collect([]));
                $venda->horario->setRelation('agendas', $agendas);
            }
        });

        $usuarios = User::latest()->limit(10)->get() ?? collect([]);
        $clinicas = Clinica::latest()->limit(10)->get() ?? collect([]);

        $vendasMensais = [
            'janeiro'   => Agendamento::whereMonth('created_at', '01')->count() ?? 0,
            'fevereiro' => Agendamento::whereMonth('created_at', '02')->count() ?? 0,
            'marco'     => Agendamento::whereMonth('created_at', '03')->count() ?? 0,
            'abril'     => Agendamento::whereMonth('created_at', '04')->count() ?? 0,
            'maio'      => Agendamento::whereMonth('created_at', '05')->count() ?? 0,
            'junho'     => Agendamento::whereMonth('created_at', '06')->count() ?? 0,
        ];

        return view('admin.sub-diretorios.dashboard.vendas', [
            'totalVendas'        => $totalVendas,
            'totalUsuarios'      => $totalUsuarios, 
            'totalClinicas'      => $totalClinicas,
            'totalClasses'       => $totalClasses,
            'totalProcedimentos' => $totalProcedimentos, // Agora com a contagem correta de procedimentos
            'totalHorarios'      => $totalHorarios,
            'totalAgendamentos'  => $totalAgendamentos,
            'vendas'             => $vendas,
            'usuarios'           => $usuarios, 
            'clinicas'           => $clinicas,
            'vendasJaneiro'      => $vendasMensais['janeiro'],
            'vendasFevereiro'    => $vendasMensais['fevereiro'],
            'vendasMarco'        => $vendasMensais['marco'],
            'vendasAbril'        => $vendasMensais['abril'],
            'vendasMaio'         => $vendasMensais['maio'],
            'vendasJunho'        => $vendasMensais['junho'],
        ]);
    }
}