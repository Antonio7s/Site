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
        Schema::create('horarios_disponiveis', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('agenda_id')->unique(); // Cada horario_disp só pode ter uma agenda
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
        Schema::dropIfExists('horarios_disponiveis');
    }
};
