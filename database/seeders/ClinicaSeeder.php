<?php

namespace Database\Seeders;

use App\Models\Clinica;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClinicaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
        public function run(): void
        {
            // Total de registros a serem criados
            $total = 60; 
            // Tamanho do lote
            $batchSize = 100;

            // Criando registros em lotes
            for ($i = 0; $i < $total; $i += $batchSize) {
                Clinica::factory($batchSize)->create();
            }
        }

}
