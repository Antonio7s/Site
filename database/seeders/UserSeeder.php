<?php

namespace Database\Seeders;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Cria cem mil usuários com a factory
        // User::factory(100000)->create();

        // Número total de usuários
        $total = 10000; // dez mil
        // Tamanho do lote
        $batchSize = 1000; // mil mil

        // Criando usuários em lotes de mil
        for ($i = 0; $i < $total; $i += $batchSize) {
            User::factory($batchSize)->create();
        }
    }

}
