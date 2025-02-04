<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MedicoProcedimento extends Model
{
    protected $fillable = ['medico_id', 'procedimento_id'];

    // Um médico procedimento pertence a um médico
    public function medico(): BelongsTo
    {
        return $this->belongsTo(Medico::class);
    }

    // Um médico procedimento pertence a um procedimento
    public function procedimento(): BelongsTo
    {
        return $this->belongsTo(Procedimento::class);
    }
}
