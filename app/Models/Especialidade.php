<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Especialidade extends Model
{
    protected $fillable = ['nome'];

    // Uma especialidade pode ser associada a vários médicos
    public function medicosEspecialidade(): HasMany
    {
        return $this->hasMany(MedicoEspecialidade::class);
    }
}
