<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Consulta extends Model
{
    // Relacionamento inverso com Agenda
    public function agenda()
    {
        return $this->belongsTo(Agenda::class);
    }

    // Relacionamento muitos para um com Paciente
    public function paciente()
    {
        return $this->belongsTo(Paciente::class);
    }
}
