<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Clinica extends Model
{
    protected $fillable = ['nome', 'endereco', 'telefone'];

    // Uma clínica pode ter vários médicos
    public function medicos(): HasMany
    {
        return $this->hasMany(Medico::class);
    }
}
