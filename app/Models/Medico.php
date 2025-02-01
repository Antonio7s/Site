<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Medico extends Model
{
    // Relacionamento um para muitos com Agenda
    public function agendas()
    {
        return $this->hasMany(Agenda::class);
    }

    // Relacionamento muitos para muitos com MedicoProcedimento
    public function procedimentos()
    {
        return $this->belongsToMany(Procedimento::class, 'medico_procedimento');
    }

    // Relacionamento muitos para muitos com Especialidade
    public function especialidades()
    {
        return $this->belongsToMany(Especialidade::class, 'medico_especialidade');
    }

    // Relacionamento um para muitos com Clinica
    public function clinicas()
    {
        return $this->hasMany(Clinica::class);
    }
}
