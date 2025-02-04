<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Agenda extends Model
{
    protected $fillable = ['data', 'horario', 'medico_id', 'paciente_nome'];

    // Uma agenda pertence a um médico
    public function medico(): BelongsTo
    {
        return $this->belongsTo(Medico::class);
    }
}
