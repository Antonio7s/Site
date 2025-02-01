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
            $table->id();  
            $table->string('clinica'); 
            $table->string('nome'); 
            $table->string('endereco'); 
            $table->string('email'); 
            $table->string('crm'); 
            $table->timestamps(); 
        });

    }
    
    public function down(): void
    {
        Schema::dropIfExists('medicos');
    }
};
