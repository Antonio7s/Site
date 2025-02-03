<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paciente extends Model
{
    // Relacionamento inverso com Consulta
    public function consultas()
    {
        return $this->hasMany(Consulta::class);
    }
}
