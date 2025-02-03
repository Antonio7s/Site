<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Clinica extends Model
{
    // Relacionamento inverso com Medico
    public function medicos()
    {
        return $this->belongsTo(Clinica::class);
    }
}

