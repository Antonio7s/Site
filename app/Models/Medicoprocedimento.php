<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MedicoProcedimento extends Model
{
    // Relacionamento muitos para um com Procedimento
    public function procedimento()
    {
        return $this->belongsTo(Procedimento::class);
    }

    // Relacionamento muitos para um com Medico
    public function medico()
    {
        return $this->belongsTo(Medico::class);
    }
}

