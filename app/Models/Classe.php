<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Classe extends Model
{
    // Relacionamento um para muitos com Procedimento
    public function procedimentos()
    {
        return $this->hasMany(Procedimento::class);
    }
}
