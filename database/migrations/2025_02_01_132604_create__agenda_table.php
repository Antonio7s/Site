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
        Schema::create('agendas', function (Blueprint $table) {
            $table->id('id_agenda');  
            $table->unsignedBigInteger('id_medico');  
            $table->date('data');  
            $table->time('hora_inicio'); 
            $table->time('hora_fim');  
            $table->timestamps();

            // Definir a chave estrangeira
            $table->foreign('id_medico')->references('id_medico')->on('medicos')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('agendas');
    }
};
