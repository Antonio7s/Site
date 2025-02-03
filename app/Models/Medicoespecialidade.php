<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MedicoEspecialidade extends Model
{
    // Relacionamento muitos para um com Medico
    public function medico()
    {
        return $this->belongsTo(Medico::class);
    }

    // Relacionamento muitos para um com Especialidade
    public function especialidade()
    {
        return $this->belongsTo(Especialidade::class);
    }
}
