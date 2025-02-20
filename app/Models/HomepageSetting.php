<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomepageSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'logo_path',
        'banner_path',
        'info_basicas',
        'play_store_link',
        'apk_link',
    ];
}