<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Agendamento; // Para vendas (agendamentos)
use App\Models\Paciente; // Para clientes (pacientes)
use App\Models\Clinica; // Para clínicas
use Illuminate\Support\Facades\DB; // Para consultas personalizadas

class DashboardController1 extends Controller
{
    public function index()
    {
        // Total de Vendas (Agendamentos)
        $totalVendas = Agendamento::count();

        // Total de Clientes (Pacientes)
        $totalClientes = Paciente::count();

        // Total de Clínicas
        $totalClinicas = Clinica::count();

        // Últimas Vendas (Agendamentos)
        $vendas = Agendamento::with(['clinica', 'paciente'])
            ->latest()
            ->take(10)
            ->get();

        // Últimos Clientes Cadastrados (Pacientes)
        $clientes = Paciente::latest()
            ->take(5)
            ->get();

        // Últimas Clínicas Cadastradas
        $clinicas = Clinica::latest()
            ->take(5)
            ->get();

        // Dados para o gráfico de crescimento de vendas (agendamentos por mês)
        $vendasPorMes = Agendamento::select(
                DB::raw('MONTH(created_at) as mes'),
                DB::raw('COUNT(*) as total')
            )
            ->whereYear('created_at', date('Y')) // Filtra pelo ano atual
            ->groupBy('mes')
            ->pluck('total', 'mes')
            ->toArray();

        // Preenche os meses faltantes com 0
        $meses = range(1, 12);
        $vendasMensais = [];
        foreach ($meses as $mes) {
            $vendasMensais[] = $vendasPorMes[$mes] ?? 0;
        }

        // Dados para o gráfico de distribuição de vendas por categoria
        $distribuicaoVendas = [
            'vendas' => $totalVendas,
            'clientes' => $totalClientes,
            'clinicas' => $totalClinicas
        ];

        // Envia todas as variáveis para a view
        return view('dashboard', compact(
            'totalVendas',
            'totalClientes',
            'totalClinicas',
            'vendas',
            'clientes',
            'clinicas',
            'vendasMensais',
            'distribuicaoVendas'
        ));
    }
}