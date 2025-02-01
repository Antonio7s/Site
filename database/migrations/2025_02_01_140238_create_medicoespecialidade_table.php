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
        Schema::create('medico_especialidade', function (Blueprint $table) {
            $table->id('medico_especialidade_id');  
            $table->unsignedBigInteger('medico_id');  
            $table->unsignedBigInteger('especialidade_id');  
            $table->date('data_atribuicao'); 
            $table->timestamps();  
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medicoespecialidade');
    }
};
