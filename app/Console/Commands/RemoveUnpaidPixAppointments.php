<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Agendamento;
use Carbon\Carbon;

class RemoveUnpaidPixAppointments extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:remove-unpaid-pix-appointments';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove agendamentos PIX não pagos em mais de 30 minutos';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // // Calcula o limite a partir do qual o agendamento é considerado expirado (30 minutos atrás)
        $expirationTime = Carbon::now()->subMinutes(30);

        // Se estiver usando o campo 'created_at':
        $agendamentos = Agendamento::where('status', 'pendente')
                        ->where('created_at', '<', $expirationTime)
                        ->get();

        // Caso esteja usando o campo 'data' definido manualmente:
        $agendamentos = Agendamento::where('status', 'pendente')
                        ->where('data', '<', $expirationTime)
                        ->get();

        // Exibe quantos agendamentos foram encontrados para remoção
        $this->info("Agendamentos a remover: " . $agendamentos->count());

        foreach ($agendamentos as $agendamento) {
            $this->info("Excluindo agendamento ID: {$agendamento->id}");
            $agendamento->delete();
        }

        $this->info("Processo concluído!");

        return 0;
    }
}
