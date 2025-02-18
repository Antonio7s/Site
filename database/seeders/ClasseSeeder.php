<?php

namespace Database\Seeders;

use App\Models\Classe;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClasseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $classes = [
            'Clínica Geral', 'Cardiologia', 'Laboratório', 'Imagem', 'Ultrassonografia',
            'Radiologia', 'Dermatologia', 'Pediatria', 'Ginecologia', 'Ortopedia',
            'Neurologia', 'Oftalmologia', 'Gastroenterologia', 'Urologia', 'Psiquiatria',
            'Cirurgia Geral', 'Endocrinologia', 'Otorrinolaringologia', 'Pneumologia',
            'Reumatologia', 'Procedimentos Especiais', 'Terapias Complementares', 'Vacinação'
        ];

        foreach ($classes as $nome) {
            Classe::firstOrCreate(['nome' => $nome]);
        }
    }
}
