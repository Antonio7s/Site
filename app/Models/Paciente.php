<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Paciente extends Model
{
    protected $fillable = ['nome', 'email', 'telefone', 'carrinho_id'];

    // Um paciente recebe informações de um carrinho
    public function carrinho(): BelongsTo
    {
        return $this->belongsTo(Carrinho::class);
    }

    // Um paciente pode ter vários agendamentos
    public function agendamentos(): HasMany
    {
        return $this->hasMany(Agendamento::class);
    }
}
