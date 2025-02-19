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
        Schema::create('medico_procedimento', function (Blueprint $table) {

            $table->unsignedBigInteger('medico_id');
            $table->unsignedBigInteger('procedimento_id');
            
            $table->foreign('medico_id')->references('id')->on('medicos')->onDelete('cascade');
            $table->foreign('procedimento_id')->references('id')->on('procedimentos')->onDelete('cascade');
            
            $table->unique(['medico_id', 'procedimento_id']);
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medico_procedimento');
    }
};
