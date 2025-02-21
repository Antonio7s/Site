<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHomepageSettingsTable extends Migration
{
    public function up()
    {
        Schema::create('homepage_settings', function (Blueprint $table) {
            $table->id();
            $table->string('logo_path')->nullable()->comment('Caminho do arquivo de logo');
            $table->string('banner_path')->nullable()->comment('Caminho do arquivo de banner');
            $table->text('info_basicas')->nullable()->comment('Informações básicas da clínica');
            $table->string('play_store_link')->nullable()->comment('Link do app na Play Store');
            $table->string('apk_link')->nullable()->comment('Link direto do APK');
            $table->timestamps();
        });

        // Adicionar índice único para garantir apenas uma configuração
        Schema::table('homepage_settings', function (Blueprint $table) {
            $table->unique('id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('homepage_settings');
    }
}
