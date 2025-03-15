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
        Schema::create('horarios', function (Blueprint $table) {
            $table->id();
            $table->date('data'); // Campo para a data do horário
            $table->time('horario_inicio'); // Campo para o horário
            $table->integer('duracao'); // Campo para a duração em minutos

            $table->unsignedBigInteger('procedimento_id')->nullable(); // null somente para testes
            $table->foreign('procedimento_id')->references('id')->on('procedimentos')->onDelete('cascade');


            $table->unsignedBigInteger('agenda_id'); // Cada horario só pode ter uma agenda
            // Definir a chave estrangeira
            $table->foreign('agenda_id')->references('id')->on('agendas')->onDelete('cascade');
            
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('horarios');
    }
};
