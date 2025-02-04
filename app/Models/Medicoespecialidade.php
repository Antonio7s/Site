<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MedicoEspecialidade extends Model
{
    protected $fillable = ['medico_id', 'especialidade'];

    // Uma especialidade pertence a um médico
    public function medico(): BelongsTo
    {
        return $this->belongsTo(Medico::class);
    }
}
