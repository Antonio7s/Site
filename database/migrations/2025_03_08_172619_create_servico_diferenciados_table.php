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
        Schema::create('servico_diferenciados', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('procedimento_id');
            $table->unsignedBigInteger('clinica_id');
            $table->decimal('preco_customizado', 8, 2);
            $table->date('data_inicial')->nullable();
            $table->date('data_final')->nullable();
            //$table->string('codigo')->unique();

            // Outros campos de personalização podem ser adicionados aqui
            $table->timestamps();

            $table->foreign('procedimento_id')->references('id')->on('procedimentos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('servico_diferenciados');
    }
};
