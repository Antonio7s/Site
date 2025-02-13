<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Procedimento extends Model
{

    protected $fillable = ['nome', 'valor','classe_id'];
    // Relacionamento muitos para um com Classe
    public function classe()
    {
        return $this->belongsTo(Classe::class);
    }

    // Relacionamento um para muitos com MedicoProcedimento
    public function medicoProcedimentos()
    {
        return $this->hasMany(MedicoProcedimento::class);
    }
}

