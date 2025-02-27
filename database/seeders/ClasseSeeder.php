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
            'Consultas', 'Exames', 'Vacinas', 'Odontologia', 'Cirurgias',
            'Check-up', 'Atendimento Online'
        ];
        
        
        foreach ($classes as $nome) {
            Classe::firstOrCreate(['nome' => $nome]);
        }
    }
}
