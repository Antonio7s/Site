<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Classe extends Model
{
    protected $fillable = ['nome'];

    // Uma classe pode ter vários procedimentos
    public function procedimentos(): HasMany
    {
        return $this->hasMany(Procedimento::class);
    }
}
