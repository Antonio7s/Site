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
            $table->enum('status', ['pendente', 'negado', 'aprovado'])->default('pendente'); // STATUS DE CADASTRO
            $table->string('razao_social')->unique(); // Razão Social
            $table->string('nome_fantasia'); // Nome Fantasia
            $table->string('cnpj_cpf')->unique(); // CNPJ ou CPF
            $table->string('email')->unique(); // Email
            $table->string('password'); // Senha

            // Campos dos dados de endereço e contato
            $table->string('telefone')->nullable();
            $table->string('cep')->nullable();
            $table->string('endereco')->nullable();
            $table->string('numero')->nullable();
            $table->string('complemento')->nullable();
            $table->string('bairro')->nullable();
            $table->string('cidade')->nullable();
            $table->string('uf')->nullable();

            // Campos de contato administrativo e financeiro
            $table->string('email_administrativo')->nullable();
            $table->string('email_faturamento')->nullable();
            $table->string('telefone_local')->nullable();
            $table->string('telefone_financeiro')->nullable();
            $table->string('celular')->nullable();

            // Campos do responsável pelo contrato
            $table->string('responsavel_nome')->nullable();
            $table->string('rg')->nullable();
            $table->string('orgao_emissor')->nullable();
            $table->date('data_emissao')->nullable();
            $table->string('responsavel_cpf')->nullable(); // Para diferenciar do cnpj_cpf da clínica
            $table->string('estado_civil')->nullable();

            // Outros campos
            $table->string('documentos')->nullable();
            $table->string('wallet_id')->nullable();
            $table->string('porcentagem_lucro')->nullable();
            $table->string('valor_fixo_lucro')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

            // Inserir o clinica exemplo "chumbado" diretamente na tabela
            DB::table('clinicas')->insert([
                'status' => 'aprovado', // O status será aprovado
                'razao_social' => 'Clínica Exemplo Ltda', // Razão Social
                'nome_fantasia' => 'Clínica Exemplo', // Nome Fantasia
                'cnpj_cpf' => '12.345.678/0001-93', // CNPJ ou CPF
                'email' => 'admin@gmail.com', // E-mail
                'password' => Hash::make('12345678'), // Senha encriptada
                'wallet_id' => '89acdcf4-a027-43f3-b822-dfce1e8824e6',
                'documentos' => null, // Pode adicionar o caminho para documentos, se necessário
                'porcentagem_lucro' => '90', // % para clinica, e o resto para o admin
                'valor_fixo_lucro' => '0',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Inserir o clinica exemplo "chumbado" diretamente na tabela
            DB::table('clinicas')->insert([
                'status' => 'aprovado', // O status será aprovado
                'razao_social' => 'Clínica Exemplo 1 Ltda', // Razão Social
                'nome_fantasia' => 'Clínica Exemplo 1', // Nome Fantasia
                'cnpj_cpf' => '12.345.678/0001-90', // CNPJ ou CPF
                'email' => 'antoniolprogramador@gmail.com', // E-mail
                'password' => Hash::make('12345678'), // Senha encriptada
                'wallet_id' => '89acdcf4-a027-43f3-b822-dfce1e8824e6',
                'documentos' => null, // Pode adicionar o caminho para documentos, se necessário
                'porcentagem_lucro' => '90', // % para clinica, e o resto para o admin
                'valor_fixo_lucro' => '0',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Inserir o clinica exemplo "chumbado" diretamente na tabela
            DB::table('clinicas')->insert([
                'status' => 'aprovado', // O status será aprovado
                'razao_social' => 'Clínica Exemplo 2 Ltda', // Razão Social
                'nome_fantasia' => 'Clínica Exemplo 2', // Nome Fantasia
                'cnpj_cpf' => '12.345.678/0001-91', // CNPJ ou CPF
                'email' => 'viniciusdasilva1819@gmail.com', // E-mail
                'password' => Hash::make('12345678'), // Senha encriptada
                'wallet_id' => '89acdcf4-a027-43f3-b822-dfce1e8824e6',
                'documentos' => null, // Pode adicionar o caminho para documentos, se necessário
                'porcentagem_lucro' => '90', // % para clinica, e o resto para o admin
                'valor_fixo_lucro' => '0',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clinicas');
    }
}
