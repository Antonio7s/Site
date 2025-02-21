<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    /**
     * Campos que podem ser preenchidos em massa.
     *
     * @var array
     */
    protected $fillable = [
        'title', // Título da categoria
        'icon',  // Ícone da categoria
        'color', // Cor da categoria
    ];
}