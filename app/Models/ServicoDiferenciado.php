<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServicoDiferenciado extends Model
{
    protected $fillable = ['procedimento_id', 'clinica_id', 'preco_customizado', 'data_inicial', 'data_final', 'codigo'];

    public function procedimento()
    {
        return $this->belongsTo(Procedimento::class);
    }
}
