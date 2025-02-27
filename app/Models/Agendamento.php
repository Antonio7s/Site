<?php

namespace App\Models;

use App\Models\Horario; 
use App\Models\Procedimento; 
use App\Models\User; 



use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Agendamento extends Model
{
    protected $fillable = [
        'data',
        'horario_id',
        'user_id',
        'status',
        'pagamento_id',
    ];



    // Um agendamento está relacionado a um horário disponível
    public function horario(): BelongsTo
    {
        return $this->belongsTo(Horario::class);
    }

    // Um agendamento está relacionado a um paciente
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}