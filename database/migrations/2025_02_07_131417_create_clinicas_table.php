<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClinicasTable extends Migration
{
    public function up()
    {
        Schema::create('clinicas', function (Blueprint $table) {
            $table->id(); // Cria o campo id, chave primária
            $table->string('name'); // Nome da clínica
            $table->string('email')->unique(); // Email da clínica, único
            $table->string('password'); // Senha da clínica
            $table->rememberToken(); // Token de "lembrar-me" para autenticação persistente
            $table->timestamps(); // Cria created_at e updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('clinicas');
    }
}
