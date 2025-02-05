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
        Schema::create('medicos', function (Blueprint $table) {
            $table->id('id_medico');  
            $table->unsignedBigInteger('id_clinica');  
            $table->string('primeiro_nome', 255);
            $table->string('segundo_nome', 255)->nullable();
            $table->string('foto')->nullable();
            $table->string('email', 255)->unique();
            $table->string('crm', 50)->unique();
            $table->timestamps();

            // Definir a chave estrangeira
            $table->foreign('id_clinica')->references('id')->on('clinicas')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('medicos');
    }
};
