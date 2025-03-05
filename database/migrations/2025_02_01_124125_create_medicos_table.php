<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User; 

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('medicos', function (Blueprint $table) {
            $table->id();  

            $table->unsignedBigInteger('clinica_id'); 
            // Definir a chave estrangeira
            $table->foreign('clinica_id')->references('id')->on('clinicas')->onDelete('cascade');
            
            $table->string('profissional_nome', 255);
            $table->string('profissional_sobrenome', 255)->nullable();
            $table->string('foto_url')->nullable();
            $table->string('email', 255)->unique();
            $table->string('conselho_nome', 20)->nullable();
            $table->string('conselho_numero', 20)->unique();
            $table->string('telefone', 25)->unique();
            $table->timestamps();

        });


        }

    public function down(): void
    {
        Schema::dropIfExists('medicos');
    }
};
