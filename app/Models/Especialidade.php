<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Especialidade extends Model
{
    protected $table = 'especialidades';

    protected $fillable = ['nome'];

    public $timestamps = true; // Se for usar created_at e updated_at

    // Relação: Especialidade pertence a muitos Médicos
    public function medicos()
    {
        return $this->belongsToMany(Medico::class, 'medico_especialidade');
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($especialidade) {
            if ($especialidade->medicos()->exists()) {
                throw new Exception("Não é possível deletar a especialidade pois ela está vinculada a um ou mais médicos.");
            }
        });
    }
}
