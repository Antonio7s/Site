<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Horario extends Model
{
    protected $fillable = 
    [   'data',
        'horario_inicio',
        'duracao',
        'agenda_id',
        'procedimento_id'];

    // Cada horário pertence a uma única agenda
    public function agenda()
    {
        return $this->belongsTo(Agenda::class);
    }

    // Um Horario está relacionado a um procedimento
    public function procedimento(): BelongsTo
    {
        return $this->belongsTo(Procedimento::class);
    }

}
