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
            $table->id(); // ID do agendamento

            // Relacionamento com a tabela de médicos
            $table->unsignedBigInteger('medico_id');
            $table->foreign('medico_id')->references('id')->on('medicos')->onDelete('cascade');

            // Relacionamento com a tabela de pacientes
            $table->unsignedBigInteger('paciente_id');
            $table->foreign('paciente_id')->references('id')->on('pacientes')->onDelete('cascade');

            // Relacionamento com a tabela de clínicas
            $table->unsignedBigInteger('clinica_id');
            $table->foreign('clinica_id')->references('id')->on('clinicas')->onDelete('cascade');

            // Relacionamento com a tabela de procedimentos
            $table->unsignedBigInteger('procedimento_id');
            $table->foreign('procedimento_id')->references('id')->on('procedimentos')->onDelete('cascade');

            // Relacionamento com a tabela de horários disponíveis
            $table->unsignedBigInteger('horario_disponivel_id');
            $table->foreign('horario_disponivel_id')->references('id')->on('horarios_disponiveis')->onDelete('cascade');

            // Campos adicionais
            $table->date('data'); // Data do agendamento
            $table->decimal('valor', 8, 2)->default(0); 
            $table->string('descricao')->nullable(); 
            $table->string('tipo')->nullable(); 

            $table->timestamps(); // created_at e updated_at
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