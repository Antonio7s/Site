<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Executa a migração.
     */
    public function up(): void
    {
        Schema::create('clinics', function (Blueprint $table) {
            $table->id(); // ID único da clinic
            $table->string('status'); // Status: [pendente, aprovado, negado]
            $table->string('razao_social'); // Razão social
            $table->string('nome_fantasia'); // Nome fantasia
            $table->string('cnpj_cpf')->unique(); // CNPJ ou CPF (único)
            $table->string('email')->unique(); // E-mail (único)
            $table->string('password'); // Senha de acesso
            $table->string('documentos')->nullable(); // Caminho do arquivo de documentos
            $table->timestamps(); // Datas de criação e atualização
        });
    }

    /**
     * Reverte a migração.
     */
    public function down(): void
    {
        Schema::dropIfExists('clinics');
    }
};