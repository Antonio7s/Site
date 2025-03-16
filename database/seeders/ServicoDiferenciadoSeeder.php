<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Clinica;
use App\Models\Procedimento;
use App\Models\ServicoDiferenciado;
use Carbon\Carbon;

class ServicoDiferenciadoSeeder extends Seeder
{
    public function run()
    {
        // Força 5 serviços diferenciados para a clínica ID 1
        $this->criarServicosParaClinica(1, 5);

        // Cria 10 serviços diferenciados aleatórios, evitando duplicação
        $this->criarServicosAleatorios(10);
    }

    private function criarServicosParaClinica($clinicaId, $quantidade)
    {
        $clinica = Clinica::find($clinicaId);

        if ($clinica) {
            $procedimentosUtilizados = [];

            for ($i = 0; $i < $quantidade; $i++) {
                // Seleciona um procedimento que ainda não foi usado nesta clínica
                $procedimento = Procedimento::whereNotIn('id', $procedimentosUtilizados)->inRandomOrder()->first();

                if ($procedimento) {
                    $procedimentosUtilizados[] = $procedimento->id;

                    ServicoDiferenciado::create([
                        'procedimento_id'   => $procedimento->id,
                        'clinica_id'        => $clinica->id,
                        'preco_customizado' => $procedimento->valor * 0.9,
                        'data_inicial'      => Carbon::now()->format('Y-m-d'),
                        'data_final'        => Carbon::now()->addMonths(6)->format('Y-m-d'),
                        //'codigo'            => mt_rand(10000000, 99999999),
                    ]);
                }
            }
        } else {
            $this->command->warn("⚠️ Clínica com ID $clinicaId não encontrada.");
        }
    }

    private function criarServicosAleatorios($quantidade)
    {
        for ($i = 0; $i < $quantidade; $i++) {
            $tentativas = 0;
            $maxTentativas = 10; // Evita loop infinito

            do {
                $clinica = Clinica::inRandomOrder()->first();
                $procedimento = Procedimento::inRandomOrder()->first();
                $existe = ServicoDiferenciado::where('clinica_id', $clinica->id)
                    ->where('procedimento_id', $procedimento->id)
                    ->exists();
                $tentativas++;
            } while ($existe && $tentativas < $maxTentativas);

            // Se encontrou uma combinação única, cria o serviço diferenciado
            if (!$existe) {
                ServicoDiferenciado::create([
                    'procedimento_id'   => $procedimento->id,
                    'clinica_id'        => $clinica->id,
                    'preco_customizado' => $procedimento->valor * 0.9,
                    'data_inicial'      => Carbon::now()->format('Y-m-d'),
                    'data_final'        => Carbon::now()->addMonths(6)->format('Y-m-d'),
                    //'codigo'            => mt_rand(10000000, 99999999),
                ]);
            }
        }
    }
}
