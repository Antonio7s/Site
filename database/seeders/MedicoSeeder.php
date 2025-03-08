<?php

namespace Database\Seeders;

use Faker\Factory as Faker;


use App\Models\Medico;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MedicoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        // Instancia o Faker para gerar dados falsos
        $faker = Faker::create();

        // Para a clínica com ID 1
        for ($i = 0; $i < 11; $i++) {
            Medico::create([
                'clinica_id' => 1,
                'profissional_nome' => $faker->firstName(),
                'profissional_sobrenome' => $faker->lastName(),
                'foto_url' => $faker->imageUrl(),
                'email' => $faker->unique()->safeEmail(),
                'conselho_nome' => 'CRM',
                'conselho_numero' => $faker->unique()->numerify('#########'),
                'telefone' => $faker->phoneNumber(),
            ]);
        }

        // Para a clínica com ID 2
        for ($i = 0; $i < 11; $i++) {
            Medico::create([
                'clinica_id' => 2,
                'profissional_nome' => $faker->firstName(),
                'profissional_sobrenome' => $faker->lastName(),
                'foto_url' => $faker->imageUrl(),
                'email' => $faker->unique()->safeEmail(),
                'conselho_nome' => 'CRM',
                'conselho_numero' => $faker->unique()->numerify('#########'),
                'telefone' => $faker->phoneNumber(),
            ]);
        }
    }
}
