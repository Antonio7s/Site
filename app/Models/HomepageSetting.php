<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomepageSetting extends Model
{
    use HasFactory;

    /**
     * Campos que podem ser preenchidos em massa.
     *
     * @var array
     */
    protected $fillable = [
        'logo_path',       // Caminho do arquivo de logo
        'banner_path',     // Caminho do arquivo de banner
        'info_basicas',   // Informações básicas da clínica
        'play_store_link', // Link do app na Play Store
        'apk_link',       // Link direto do APK
    ];
}