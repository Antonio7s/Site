<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Agendamento extends Model
{
    protected $fillable = ['data', 'horario_disponivel_id', 'procedimento_id', 'medico_id', 'paciente_nome'];

    // Um agendamento está relacionado a um procedimento
    public function procedimento(): BelongsTo
    {
        return $this->belongsTo(Procedimento::class);
    }

    // Um agendamento está relacionado a um horário disponível
    public function horarioDisponivel(): BelongsTo
    {
        return $this->belongsTo(HorarioDisponivel::class);
    }
}
