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
            // Procedimentos originais
            ['nome' => 'Consulta Clínica Geral', 'valor' => 100.00, 'classe_id' => 1],
            ['nome' => 'Consulta Cardiologia', 'valor' => 200.00, 'classe_id' => 2],
            ['nome' => 'Exame de Sangue', 'valor' => 50.00, 'classe_id' => 3],
            ['nome' => 'Ressonância Magnética', 'valor' => 600.00, 'classe_id' => 4],
            ['nome' => 'Ultrassom', 'valor' => 250.00, 'classe_id' => 5],
            ['nome' => 'Raio-X', 'valor' => 150.00, 'classe_id' => 6],

            // Dermatologia
            ['nome' => 'Consulta Dermatologia', 'valor' => 180.00, 'classe_id' => 7],
            ['nome' => 'Biópsia de Pele', 'valor' => 300.00, 'classe_id' => 7],
            ['nome' => 'Crioterapia', 'valor' => 150.00, 'classe_id' => 7],
            ['nome' => 'Peeling Químico', 'valor' => 400.00, 'classe_id' => 7],

            // Pediatria
            ['nome' => 'Consulta Pediatria', 'valor' => 150.00, 'classe_id' => 8],
            ['nome' => 'Vacinação Infantil', 'valor' => 120.00, 'classe_id' => 8],
            ['nome' => 'Teste do Pezinho', 'valor' => 90.00, 'classe_id' => 8],
            ['nome' => 'Acompanhamento Neonatal', 'valor' => 130.00, 'classe_id' => 8],

            // Ginecologia
            ['nome' => 'Consulta Ginecologia', 'valor' => 200.00, 'classe_id' => 9],
            ['nome' => 'Exame Papanicolau', 'valor' => 80.00, 'classe_id' => 9],
            ['nome' => 'Ultrassom Transvaginal', 'valor' => 280.00, 'classe_id' => 9],
            ['nome' => 'Colposcopia', 'valor' => 350.00, 'classe_id' => 9],

            // Ortopedia
            ['nome' => 'Consulta Ortopedia', 'valor' => 220.00, 'classe_id' => 10],
            ['nome' => 'Raio-X Articular', 'valor' => 160.00, 'classe_id' => 10],
            ['nome' => 'Imobilização de Fratura', 'valor' => 300.00, 'classe_id' => 10],
            ['nome' => 'Infiltração Articular', 'valor' => 450.00, 'classe_id' => 10],

            // Neurologia
            ['nome' => 'Consulta Neurologia', 'valor' => 250.00, 'classe_id' => 11],
            ['nome' => 'Eletroencefalograma', 'valor' => 400.00, 'classe_id' => 11],
            ['nome' => 'Polissonografia', 'valor' => 800.00, 'classe_id' => 11],
            ['nome' => 'Botox para Enxaqueca', 'valor' => 1200.00, 'classe_id' => 11],

            // Oftalmologia
            ['nome' => 'Consulta Oftalmologia', 'valor' => 150.00, 'classe_id' => 12],
            ['nome' => 'Exame de Refração', 'valor' => 120.00, 'classe_id' => 12],
            ['nome' => 'Cirurgia de Catarata', 'valor' => 5000.00, 'classe_id' => 12],
            ['nome' => 'Topografia Corneana', 'valor' => 200.00, 'classe_id' => 12],

            // Gastroenterologia
            ['nome' => 'Consulta Gastroenterologia', 'valor' => 200.00, 'classe_id' => 13],
            ['nome' => 'Endoscopia Digestiva', 'valor' => 600.00, 'classe_id' => 13],
            ['nome' => 'Colonoscopia', 'valor' => 800.00, 'classe_id' => 13],
            ['nome' => 'Manometria Esofágica', 'valor' => 450.00, 'classe_id' => 13],

            // Urologia
            ['nome' => 'Consulta Urologia', 'valor' => 200.00, 'classe_id' => 14],
            ['nome' => 'Ultrassom Prostático', 'valor' => 250.00, 'classe_id' => 14],
            ['nome' => 'PSA', 'valor' => 90.00, 'classe_id' => 14],
            ['nome' => 'Cirurgia de Próstata', 'valor' => 4000.00, 'classe_id' => 14],

            // Psiquiatria
            ['nome' => 'Consulta Psiquiatria', 'valor' => 300.00, 'classe_id' => 15],
            ['nome' => 'Sessão de Psicoterapia', 'valor' => 200.00, 'classe_id' => 15],
            ['nome' => 'Avaliação Neuropsicológica', 'valor' => 450.00, 'classe_id' => 15],
            ['nome' => 'Eletroconvulsoterapia', 'valor' => 1200.00, 'classe_id' => 15],

            // Cirurgia Geral
            ['nome' => 'Cirurgia de Apêndice', 'valor' => 2500.00, 'classe_id' => 16],
            ['nome' => 'Cirurgia de Hérnia', 'valor' => 1800.00, 'classe_id' => 16],
            ['nome' => 'Cirurgia de Vesícula', 'valor' => 3000.00, 'classe_id' => 16],
            ['nome' => 'Cirurgia Bariátrica', 'valor' => 15000.00, 'classe_id' => 16],

            // Endocrinologia
            ['nome' => 'Consulta Endocrinologia', 'valor' => 220.00, 'classe_id' => 17],
            ['nome' => 'Dosagem Hormonal', 'valor' => 180.00, 'classe_id' => 17],
            ['nome' => 'Exame de Tireoide', 'valor' => 150.00, 'classe_id' => 17],
            ['nome' => 'Monitoramento Glicêmico', 'valor' => 120.00, 'classe_id' => 17],

            // Otorrinolaringologia
            ['nome' => 'Consulta Otorrino', 'valor' => 180.00, 'classe_id' => 18],
            ['nome' => 'Audiometria', 'valor' => 120.00, 'classe_id' => 18],
            ['nome' => 'Endoscopia Nasal', 'valor' => 300.00, 'classe_id' => 18],
            ['nome' => 'Cirurgia de Septo', 'valor' => 3500.00, 'classe_id' => 18],

            // Pneumologia
            ['nome' => 'Consulta Pneumologia', 'valor' => 200.00, 'classe_id' => 19],
            ['nome' => 'Espirometria', 'valor' => 150.00, 'classe_id' => 19],
            ['nome' => 'Broncoscopia', 'valor' => 800.00, 'classe_id' => 19],
            ['nome' => 'Teste Alérgico', 'valor' => 200.00, 'classe_id' => 19],

            // Reumatologia
            ['nome' => 'Consulta Reumatologia', 'valor' => 220.00, 'classe_id' => 20],
            ['nome' => 'Exame Fator Reumatoide', 'valor' => 130.00, 'classe_id' => 20],
            ['nome' => 'Densitometria Óssea', 'valor' => 300.00, 'classe_id' => 20],
            ['nome' => 'Infiltração Articular', 'valor' => 300.00, 'classe_id' => 20],

            // Exames Laboratoriais Adicionais
            ['nome' => 'Exame de Colesterol', 'valor' => 70.00, 'classe_id' => 3],
            ['nome' => 'Exame de Função Hepática', 'valor' => 120.00, 'classe_id' => 3],
            ['nome' => 'Exame TSH', 'valor' => 90.00, 'classe_id' => 3],
            ['nome' => 'Exame de Ferro Sérico', 'valor' => 85.00, 'classe_id' => 3],

            // Imagens Adicionais
            ['nome' => 'Ressonância Cardíaca', 'valor' => 850.00, 'classe_id' => 4],
            ['nome' => 'Ultrassom Doppler', 'valor' => 350.00, 'classe_id' => 5],
            ['nome' => 'Raio-X Panorâmico', 'valor' => 200.00, 'classe_id' => 6],
            ['nome' => 'Mamografia', 'valor' => 280.00, 'classe_id' => 6],

            // Procedimentos Especiais
            ['nome' => 'Hemodiálise', 'valor' => 600.00, 'classe_id' => 21],
            ['nome' => 'Quimioterapia', 'valor' => 1200.00, 'classe_id' => 21],
            ['nome' => 'Fisioterapia Respiratória', 'valor' => 100.00, 'classe_id' => 22],
            ['nome' => 'Acupuntura', 'valor' => 120.00, 'classe_id' => 22],
            ['nome' => 'Vacina Antirrábica', 'valor' => 150.00, 'classe_id' => 23],
            ['nome' => 'Vacina Febre Amarela', 'valor' => 180.00, 'classe_id' => 23]
        ];

        Procedimento::insert($procedimentos);
    }
}
