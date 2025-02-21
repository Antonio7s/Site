<?php

namespace Database\Seeders;

use App\Models\Agenda;
use App\Models\Medico;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AgendaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        // Buscar todos os médicos
        $medicos = Medico::all();

        // Criar uma agenda para cada médico que não tenha
        foreach ($medicos as $medico) {
            // Verifica se o médico já tem uma agenda, se não, cria uma
            Agenda::firstOrCreate(
                ['medico_id' => $medico->id],  // Condição de busca
                ['medico_id' => $medico->id]   // Dados para criação
            );
        }
    }
}
