<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Especialidade extends Model
{
    // Relacionamento um para muitos com MedicoEspecialidade
    public function medicoEspecialidades()
    {
        return $this->hasMany(MedicoEspecialidade::class);
    }
}
