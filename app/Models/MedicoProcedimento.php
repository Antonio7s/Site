<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class MedicoProcedimento extends Pivot
{
    protected $table = 'medico_procedimento';

    protected $fillable = ['medico_id', 'procedimento_id'];
}

