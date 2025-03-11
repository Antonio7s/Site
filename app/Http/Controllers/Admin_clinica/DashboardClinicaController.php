<?php

namespace App\Http\Controllers\Admin_clinica;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardClinicaController extends Controller
{
    public function index()
    {
        // Data de hoje no formato AAAA-MM-DD
        $hojeStr = date('Y-m-d');

        // Dados de exemplo para "hoje"
        $categoryDataHoje = [8, 5, 3, 4]; // Ex.: Consultas, Exames, Checkup, Odontologia
        $salesDataHoje = [
            'labels' => ['08:00', '10:00', '12:00', '14:00', '16:00', '18:00'],
            'data'   => [2, 4, 3, 5, 2, 3]
        ];
        $doctorsAgendaHoje = [
            [
                'medico' => 'Dr. João',
                'foto'   => 'https://via.placeholder.com/50',
                'agenda' => [
                    ['horario' => '08:30', 'paciente' => 'Ana Paula', 'status' => 'Confirmado'],
                    ['horario' => '10:00', 'paciente' => 'Marcos Vinícius', 'status' => 'Pendente']
                ]
            ],
            [
                'medico' => 'Dra. Maria',
                'foto'   => 'https://via.placeholder.com/50',
                'agenda' => [
                    ['horario' => '09:00', 'paciente' => 'Carlos Silva', 'status' => 'Confirmado'],
                    ['horario' => '11:15', 'paciente' => 'Beatriz Costa', 'status' => 'Cancelado'],
                    ['horario' => '13:00', 'paciente' => 'Pedro Henrique', 'status' => 'Confirmado']
                ]
            ],
            [
                'medico' => 'Dr. Pedro',
                'foto'   => 'https://via.placeholder.com/50',
                'agenda' => [
                    ['horario' => '08:45', 'paciente' => 'Fernanda Souza', 'status' => 'Confirmado'],
                    ['horario' => '12:30', 'paciente' => 'Rafael Lima', 'status' => 'Pendente']
                ]
            ]
        ];

        // Dados de exemplo para "semana"
        $categoryDataSemana = [40, 25, 20, 15];
        $salesDataSemana = [
            'labels' => ['Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb', 'Dom'],
            'data'   => [5, 6, 7, 8, 6, 4, 3]
        ];
        // Para exemplo, reutilizamos a agenda de hoje
        $doctorsAgendaSemana = $doctorsAgendaHoje;

        // Dados de exemplo para "mês"
        $categoryDataMes = [160, 100, 80, 60];
        $salesDataMes = [
            'labels' => ['Semana 1', 'Semana 2', 'Semana 3', 'Semana 4'],
            'data'   => [20, 25, 18, 22]
        ];
        $doctorsAgendaMes = $doctorsAgendaHoje;

        return view('admin-clinica.dashboard.index', compact(
            'categoryDataHoje',
            'salesDataHoje',
            'doctorsAgendaHoje',
            'hojeStr',
            'categoryDataSemana',
            'salesDataSemana',
            'doctorsAgendaSemana',
            'categoryDataMes',
            'salesDataMes',
            'doctorsAgendaMes'
        ));
    }
} 