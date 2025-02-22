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
            $table->id('id');
            
            $table->unsignedBigInteger('medico_id')->unique(); // Cada médico só pode ter uma agenda
            // Definir a chave estrangeira
            $table->foreign('medico_id')->references('id')->on('medicos')->onDelete('cascade');
            
            $table->timestamps();


        });
    }

    public function down(): void
    {
        Schema::dropIfExists('agendas');
    }
};