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

            $table->enum('status', ['pendente', 'cancelado', 'agendado', 'concluido' ]);
            $table->unsignedBigInteger('pagamento_id')->unique()->nullable();

            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('horario_id')->unique(); // Garante que cada horário tenha no máximo um agendamento
            

            $table->timestamps();

            // Chaves estrangeiras 
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('horario_id')->references('id')->on('horarios')->onDelete('restrict'); // restrict
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
