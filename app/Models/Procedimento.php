<?php

namespace App\Models;
use Exception;

use Illuminate\Database\Eloquent\Model;
use App\Models\MedicoProcedimento;

class Procedimento extends Model
{

    protected $fillable = ['nome', 'valor','classe_id'];
    // Relacionamento muitos para um com Classe
    public function classe()
    {
        return $this->belongsTo(Classe::class);
    }

    // Relacionamento um para muitos com MedicoProcedimento
    public function medicos()
    {
        return $this->belongsToMany(Medico::class, 'medico_procedimento');
    }

    public function servicosDiferenciados()
    {
        return $this->hasMany(ServicoDiferenciado::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($procedimento) {
            // Verifica se existem médicos vinculados
            if ($procedimento->medicos()->exists()) {
                throw new Exception("Não é possível deletar o procedimento pois ele está vinculado a um ou mais médicos.");
            }

            // Verifica se existem serviços diferenciados vinculados
            if ($procedimento->servicosDiferenciados()->exists()) {
                throw new Exception("Não é possível deletar o procedimento pois ele está vinculado a serviços diferenciados.");
            }

            // Se desejar verificar outros relacionamentos, inclua aqui.
        });
    }
}

