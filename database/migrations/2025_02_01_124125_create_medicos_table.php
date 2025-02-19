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
            
            //$table->unsignedBigInteger('medicoclasse_id'); // TABELA INTERMEDIARIA
            //$table->unsignedBigInteger('medicoprocedimento_id');  // TABELA INTERMEDIARIA
            $table->string('primeiro_nome', 255);
            $table->string('segundo_nome', 255)->nullable();
            $table->string('foto_url')->nullable();
            $table->string('email', 255)->unique();
            $table->string('crm', 50)->unique();
            $table->timestamps();

        });

            // Cria o usuário admin
            User::create([
                'name' => 'admin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('12345678'), // Criptografa a senha
                'is_admin' => true, // Define como admin
            ]);
        }

    public function down(): void
    {
        Schema::dropIfExists('medicos');
    }
};
