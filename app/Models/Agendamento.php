<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Agendamento extends Model
{
    protected $fillable = [
        'data',
        'horario_id',
        'procedimento_id',
        'medico_id',
        'paciente_id', // Adicionado para relacionamento com Paciente
        'clinica_id',  // Adicionado para relacionamento com Clinica
        'valor',       // Adicionado para armazenar o valor da venda
        'descricao',   // Adicionado para descrição do agendamento
        'tipo'         // Adicionado para tipo de agendamento (ex: consulta, exame, etc.)
    ];

    // Um agendamento está relacionado a um procedimento
    public function procedimento(): BelongsTo
    {
        return $this->belongsTo(Procedimento::class);
    }

    // Um agendamento está relacionado a um horário disponível
    public function horario(): BelongsTo
    {
        return $this->belongsTo(Horario::class);
    }

    // Um agendamento está relacionado a uma clínica
    public function clinica(): BelongsTo
    {
        return $this->belongsTo(Clinica::class);
    }

    // Um agendamento está relacionado a um paciente
    public function paciente(): BelongsTo
    {
        return $this->belongsTo(Paciente::class);
    }
}