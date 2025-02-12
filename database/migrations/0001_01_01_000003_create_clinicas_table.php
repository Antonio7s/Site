<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClinicasTable extends Migration
{
    public function up()
    {
        Schema::create('clinicas', function (Blueprint $table) {
            $table->id();
            $table->string('razao_social')->unique(); // Razão Social
            $table->string('nome_fantasia'); // Nome Fantasia
            $table->string('cnpj_cpf')->unique(); // CNPJ ou CPF
            $table->string('email')->unique(); // Email
            $table->string('password'); // Senha
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clinicas');
    }
}
