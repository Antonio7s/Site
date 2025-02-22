<?php

namespace Database\Seeders;

use App\Models\Agendamento;
use App\Models\User;
use App\Models\Horario;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class AgendamentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Pegue os primeiros 21 usuários e 21 horários
        $users = User::take(21)->get();
        $horarios = Horario::take(21)->get();

        // Verifique se temos dados suficientes
        if ($users->count() < 21 || $horarios->count() < 21) {
            echo "Não há usuários ou horários suficientes para criar 21 agendamentos.\n";
            echo "Usuários encontrados: " . $users->count() . "\n";
            echo "Horários encontrados: " . $horarios->count() . "\n";
            return;
        }

        // Criar os 21 agendamentos
        $agendamentosCriados = 0;

        foreach ($users as $index => $user) {
            if (isset($horarios[$index])) {
                // Criação do agendamento
                $agendamento = Agendamento::create([
                    'data' => Carbon::now()->addDays(1)->toDateString(), // Data do agendamento: amanhã
                    'horario_id' => $horarios[$index]->id, // Horário
                    'user_id' => $user->id, // Usuário
                    'status' => 'agendado', // Status do agendamento
                ]);

                // Verifique se o agendamento foi criado com sucesso
                if ($agendamento) {
                    $agendamentosCriados++;
                }
            }

            // Se já foram criados 21 agendamentos, pare o loop
            if ($agendamentosCriados >= 21) {
                break;
            }
        }

        // Mensagem de sucesso ou erro
        if ($agendamentosCriados > 0) {
            echo "$agendamentosCriados agendamentos criados com sucesso.\n";
        } else {
            echo "Nenhum agendamento foi criado.\n";
        }
    }
}
