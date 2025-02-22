<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Clinic extends Authenticatable
{
    use Notifiable, HasFactory;

    // Nome da tabela no banco de dados
    protected $table = 'clinics';

    // Campos que podem ser preenchidos em massa
    protected $fillable = [
        'status', // [pendente, aprovado, negado]
        'razao_social', // Razão social
        'nome_fantasia', // Nome fantasia
        'cnpj_cpf', // CNPJ ou CPF
        'email',
        'password',
        'documentos', // Caminho do arquivo de documentos
    ];

    // Campos a serem ocultados (não aparecerão nas respostas de JSON, por exemplo)
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Relacionamento com Médicos (Clinic tem muitos Médicos)
    public function medicos()
    {
        return $this->hasMany(Medico::class); // Assume-se que existe o modelo Medico
    }
}