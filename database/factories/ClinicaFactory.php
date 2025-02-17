<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Clinica>
 */
class ClinicaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'status' => $this->faker->randomElement(['pendente', 'aprovado', 'negado']),
            'razao_social' => $this->faker->unique()->company,
            'nome_fantasia' => $this->faker->companySuffix,
            'cnpj_cpf' => $this->faker->unique()->numerify('##############'), // Simulando CPF/CNPJ
            'email' => $this->faker->unique()->safeEmail,
            'password' => bcrypt('password'), // Senha fixa para testes
            'documentos' => 'uploads/documentos/' . $this->faker->uuid . '.pdf', // Simulando caminho do arquivo
        ];
    }
}
