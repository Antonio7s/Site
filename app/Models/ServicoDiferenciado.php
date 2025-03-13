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

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($servico) {
            // Exemplo: não permitir a deleção se o serviço estiver vinculado a um procedimento.
            if ($servico->procedimento()->exists()) {
                throw new Exception("Não é possível deletar o serviço diferenciado pois ele está vinculado a um procedimento.");
            }

            // Se houver outros relacionamentos ou regras de negócio, adicione aqui a verificação.
        });
    }
}
