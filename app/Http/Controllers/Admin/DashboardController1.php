<?php 

namespace App\Http\Controllers\Admin;

use App\Models\Consulta;
use App\Models\Agendamento;
use App\Models\User;
use App\Models\Clinica;

class DashboardController1 extends Controller
{
    public function index()
    {
        // Consultas: supondo que você tenha um campo 'tipo' para diferenciar presencial e remota
        $consulta_presencial = Consulta::where('tipo', 'presencial')->count();
        $consulta_remota    = Consulta::where('tipo', 'remota')->count();

        // Exames, Vacinas e Odontologia:
        // Se a classe/model existir, executa o count; caso contrário, atribui 0.
        $exames      = class_exists(\App\Models\Exame::class) ? \App\Models\Exame::count() : 0;
        $vacinas     = class_exists(\App\Models\Vacina::class) ? \App\Models\Vacina::count() : 0;
        $odontologia = class_exists(\App\Models\Odontologia::class) ? \App\Models\Odontologia::count() : 0;

        // Últimas vendas
        $vendas = Agendamento::latest()->take(10)->get(); // exemplo: se Agendamento representa vendas

        // Últimos clientes (supondo que sejam usuários ou pacientes)
        $clientes = User::latest()->take(5)->get();

        // Últimas clínicas
        $clinicas = Clinica::latest()->take(5)->get();

        // Envia todas as variáveis para a view
        return view('dashboard', compact(
            'consulta_presencial',
            'consulta_remota',
            'exames',
            'vacinas',
            'odontologia',
            'vendas',
            'clientes',
            'clinicas'
        ));
    }
}
