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
            $table->id('medico_procedimento_id');  
            $table->unsignedBigInteger('medico_id'); 
            $table->unsignedBigInteger('procedimento_id');  
            $table->timestamps();  
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medicoprocedimento');
    }
};
