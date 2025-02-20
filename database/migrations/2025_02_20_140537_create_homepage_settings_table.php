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
            $table->string('logo_path')->nullable();
            $table->string('banner_path')->nullable();
            $table->text('info_basicas')->nullable();
            $table->string('play_store_link')->nullable();
            $table->string('apk_link')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('homepage_settings');
    }
}
