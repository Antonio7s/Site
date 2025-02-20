<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Agenda extends Model
{
    protected $fillable = ['medico_id', 'paciente_id'];

    // Um agenda possui muitos horários
    public function horarios()
    {
        return $this->hasMany(Horario::class);
    }

    // Uma agenda pertence a um único médico
    public function medico(): BelongsTo
    {
        return $this->belongsTo(Medico::class);
    }
}
