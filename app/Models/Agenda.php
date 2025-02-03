<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Agenda extends Model
{
    // Relacionamento inverso com Medico
    public function medico()
    {
        return $this->belongsTo(Medico::class);
    }

    // Relacionamento um para muitos com Consulta
    public function consultas()
    {
        return $this->hasMany(Consulta::class);
    }
}
