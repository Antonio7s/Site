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
            $table->id('agendamento_id');
            $table->time('horario');
            
            $table->unsignedBigInteger('paciente_id');
            $table->unsignedBigInteger('procedimento_id');
            $table->unsignedBigInteger('horario_disponivel_id');
            $table->string('status'); // Pode ser 'agendado', 'cancelado', etc.
            $table->timestamps();

            // Definir chaves estrangeiras (ajustando para suas tabelas)
            $table->foreign('paciente_id')->references('id')->on('pacientes')->onDelete('cascade');
            $table->foreign('procedimento_id')->references('id')->on('procedimentos')->onDelete('cascade');
            $table->foreign('horario_disponivel_id')->references('id')->on('horarios_disponiveis')->onDelete('cascade');
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
