<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('agendamentos', function (Blueprint $table) {
            $table->id('id');
            
            // Adicionando a coluna 'data' (tipo DATE ou DATETIME)
            $table->date('data'); // Ou $table->datetime('data'); se precisar incluir a hora

            $table->string('status'); // Pode ser 'agendado', 'cancelado', 'concluido' etc.

            $table->unsignedBigInteger('procedimento_id');
            $table->unsignedBigInteger('paciente_id');
            $table->unsignedBigInteger('horario_id')->unique(); // Garante que cada horário tenha no máximo um agendamento
            
            $table->timestamps();

            // Definir chaves estrangeiras (ajustando para suas tabelas)
            $table->foreign('paciente_id')->references('id')->on('pacientes')->onDelete('cascade');
            $table->foreign('procedimento_id')->references('id')->on('procedimentos')->onDelete('cascade');
            $table->foreign('horario_id')->references('id')->on('horarios')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agendamentos');
    }
};
