<?php

namespace Database\Seeders;

use App\Models\Procedimento;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProcedimentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $procedimentos = [
            // Consultas
            ['nome' => 'Consulta Clínica Geral', 'valor' => 100.00, 'classe_id' => 1],
            ['nome' => 'Consulta Cardiologia', 'valor' => 200.00, 'classe_id' => 1],
            ['nome' => 'Consulta Dermatologia', 'valor' => 180.00, 'classe_id' => 1],
            ['nome' => 'Consulta Pediatria', 'valor' => 150.00, 'classe_id' => 1],
            ['nome' => 'Consulta Ginecologia', 'valor' => 200.00, 'classe_id' => 1],
            ['nome' => 'Consulta Ortopedia', 'valor' => 220.00, 'classe_id' => 1],
            ['nome' => 'Consulta Neurologia', 'valor' => 250.00, 'classe_id' => 1],
            ['nome' => 'Consulta Oftalmologia', 'valor' => 150.00, 'classe_id' => 1],
            ['nome' => 'Consulta Gastroenterologia', 'valor' => 200.00, 'classe_id' => 1],
            ['nome' => 'Consulta Urologia', 'valor' => 200.00, 'classe_id' => 1],
            ['nome' => 'Consulta Psiquiatria', 'valor' => 300.00, 'classe_id' => 1],
            ['nome' => 'Consulta Endocrinologia', 'valor' => 220.00, 'classe_id' => 1],
            ['nome' => 'Consulta Otorrino', 'valor' => 180.00, 'classe_id' => 1],
            ['nome' => 'Consulta Pneumologia', 'valor' => 200.00, 'classe_id' => 1],
            ['nome' => 'Consulta Reumatologia', 'valor' => 220.00, 'classe_id' => 1],

            // Exames
            ['nome' => 'Exame de Sangue', 'valor' => 50.00, 'classe_id' => 2],
            ['nome' => 'Exame de Colesterol', 'valor' => 70.00, 'classe_id' => 2],
            ['nome' => 'Exame de Função Hepática', 'valor' => 120.00, 'classe_id' => 2],
            ['nome' => 'Exame TSH', 'valor' => 90.00, 'classe_id' => 2],
            ['nome' => 'Exame de Ferro Sérico', 'valor' => 85.00, 'classe_id' => 2],

            // Vacinas
            ['nome' => 'Vacina Antirrábica', 'valor' => 150.00, 'classe_id' => 3],
            ['nome' => 'Vacina Febre Amarela', 'valor' => 180.00, 'classe_id' => 3],
            ['nome' => 'Vacinação Infantil', 'valor' => 120.00, 'classe_id' => 3],

            // Cirurgias
            ['nome' => 'Cirurgia de Apêndice', 'valor' => 2500.00, 'classe_id' => 4],
            ['nome' => 'Cirurgia de Hérnia', 'valor' => 1800.00, 'classe_id' => 4],
            ['nome' => 'Cirurgia de Vesícula', 'valor' => 3000.00, 'classe_id' => 4],
            ['nome' => 'Cirurgia Bariátrica', 'valor' => 15000.00, 'classe_id' => 4],

            // Check-up
            ['nome' => 'Ressonância Magnética', 'valor' => 600.00, 'classe_id' => 5],
            ['nome' => 'Ultrassom', 'valor' => 250.00, 'classe_id' => 5],
            ['nome' => 'Raio-X', 'valor' => 150.00, 'classe_id' => 5],

            // Atendimento Online
            ['nome' => 'Consulta Online', 'valor' => 100.00, 'classe_id' => 6],
            ['nome' => 'Atendimento de Emergência Online', 'valor' => 200.00, 'classe_id' => 6],
        ];

        Procedimento::insert($procedimentos);
    }
}
