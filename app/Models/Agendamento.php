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
        'voucher',
    ];


    protected static function booted()
    {
        static::creating(function ($agendamento) {
            $agendamento->voucher = self::generateUniqueVoucher();
        });
    }

    private static function generateUniqueVoucher(): string
    {
        do {
            // Gera um código aleatório de 5 dígitos numéricos
            $voucher = str_pad(random_int(0, 99999), 5, '0', STR_PAD_LEFT);
        } while (self::where('voucher', $voucher)->exists());

        return $voucher;
    }


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