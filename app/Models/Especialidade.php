<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Especialidade extends Model
{
    protected $table = 'especialidades';
    protected $fillable = ['especialidade'];
    public $timestamps = true; // Se for usar created_at e updated_at

    // Uma especialidade pode ser associada a vários médicos
    public function medicosEspecialidade(): HasMany
    {
        return $this->hasMany(MedicoEspecialidade::class);
    }
}
