<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Horario extends Model
{
    protected $fillable = ['data', 'horario_inicio', 'duracao', 'agenda_id'];

    // Cada horário pertence a uma única agenda
    public function agenda()
    {
        return $this->belongsTo(Agenda::class);
    }
}
