<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class HorarioDisponivel extends Model
{
    protected $fillable = ['data', 'horario', 'status', 'agenda_id'];

    // Um horário disponível pode estar associado a vários agendamentos
    public function agendamentos(): HasMany
    {
        return $this->hasMany(Agendamento::class);
    }
}
