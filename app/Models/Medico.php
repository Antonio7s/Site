<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Medico extends Model
{
    protected $fillable = ['nome', 'crm', 'clinica_id'];

    // Um médico pertence a uma clínica
    public function clinica(): BelongsTo
    {
        return $this->belongsTo(Clinica::class);
    }

    // Um médico pode ter vários agendamentos
    public function agendas(): HasMany
    {
        return $this->hasMany(Agenda::class);
    }

    // Um médico pode ter várias especialidades
    public function especialidades(): HasMany
    {
        return $this->hasMany(MedicoEspecialidade::class);
    }

    // Um médico pode realizar vários procedimentos
    // OU SEJA, AO RESGATAR O MÉDICO DEVEM VIM TODOS SEUS PROCEDIMENTOS
    public function procedimentos(): HasMany
    {
        return $this->hasMany(MedicoProcedimento::class);
    }
}
