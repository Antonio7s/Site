<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;


use App\Models\Medico;
use App\Models\Especialidade;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MedicoEspecialidadeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        // Recupera os médicos e especialidades existentes no banco de dados
        $medicos = Medico::all();
        $especialidades = Especialidade::all();

        // Associar cada médico com algumas especialidades (aleatoriamente)
        foreach ($medicos as $medico) {
            // Vamos associar aleatoriamente entre 1 e 3 especialidades a cada médico
            $especialidadesSelecionadas = $especialidades->random(rand(1, 3)); // Seleciona entre 1 a 3 especialidades aleatórias

            foreach ($especialidadesSelecionadas as $especialidade) {
                DB::table('medico_especialidade')->insert([
                    'medico_id' => $medico->id,
                    'especialidade_id' => $especialidade->id,
                ]);
            }
        }
    }
}
