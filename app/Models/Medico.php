<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Medico extends Model
{
    protected $fillable = ['primeiro_nome','segundo_nome', 'email', 'telefone', 'conselho_nome','conselho_numero', 'clinica_id', 'foto_url'];

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

    // Relação: Médico tem muitas Especialidades (muitos-para-muitos)
    public function especialidades()
    {
        return $this->belongsToMany(Especialidade::class, 'medico_especialidade')->using(MedicoEspecialidade::class);;
    }

    // Relação: Médico tem muitos Procedimentos (muitos-para-muitos)
    public function procedimentos()
    {
        return $this->belongsToMany(Procedimento::class, 'medico_procedimento')->using(MedicoProcedimento::class);
    }
}
