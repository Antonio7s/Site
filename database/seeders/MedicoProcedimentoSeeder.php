<?php

namespace Database\Seeders;


use Illuminate\Support\Facades\DB;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Medico;
use App\Models\Procedimento;

class MedicoProcedimentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Recupera os médicos e procedimentos existentes no banco de dados
        $medicos = Medico::all();
        $procedimentos = Procedimento::all();

        // Associar cada médico com alguns procedimentos (aleatoriamente)
        foreach ($medicos as $medico) {
            // Vamos associar aleatoriamente entre 1 e 5 procedimentos a cada médico
            $procedimentosSelecionados = $procedimentos->random(rand(1, 5)); // Seleciona entre 1 a 5 procedimentos aleatórios

            foreach ($procedimentosSelecionados as $procedimento) {
                DB::table('medico_procedimento')->insert([
                    'medico_id' => $medico->id,
                    'procedimento_id' => $procedimento->id,
                ]);
            }
        }
    
    }
}
