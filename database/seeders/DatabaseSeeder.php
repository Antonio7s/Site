<?php

namespace Database\Seeders;

use App\Models\User;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        /*
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
        */

        $this->call(UserSeeder::class);
        $this->call(ClinicaSeeder::class);

        $this->call(EspecialidadeSeeder::class);
        $this->call(ClasseSeeder::class); 
        $this->call(ProcedimentoSeeder::class); 
        $this->call(MedicoSeeder::class);
        $this->call(MedicoEspecialidadeSeeder::class);
        $this->call(MedicoProcedimentoSeeder::class);
        $this->call(HorarioSeeder::class);
    }
}
