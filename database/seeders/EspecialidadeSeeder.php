<?php

namespace Database\Seeders;

use App\Models\Especialidade;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EspecialidadeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $especialidades = [
            ['nome' => 'Cardiologia'],
            ['nome' => 'Dermatologia'],
            ['nome' => 'Ginecologia'],
            ['nome' => 'Pediatria'],
            ['nome' => 'Ortopedia'],
            ['nome' => 'Oftalmologia'],
            ['nome' => 'Neurologia'],
            ['nome' => 'Psiquiatria'],
        ];

        Especialidade::insert($especialidades);
    }
}
