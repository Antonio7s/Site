<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Clinica extends Authenticatable
{
    use Notifiable;

    // Definindo a tabela que a Clínica usa (caso seja diferente do padrão 'clinicas')
    protected $table = 'clinicas';

    // Campos preenchíveis (os que podem ser atribuídos em massa)
    protected $fillable = [
        'razao_social', // Novo campo para a Razão Social
        'nome_fantasia', // Novo campo para o Nome Fantasia
        'cnpj_cpf', // Novo campo para CNPJ ou CPF
        'email',
        'password',
    ];

    // Campos a serem ocultados (não aparecerão nas respostas de JSON, por exemplo)
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Relacionamento com Médicos (Clinica tem muitos Médicos)
    public function medicos()
    {
        return $this->hasMany(Medico::class); // Assume-se que existe o modelo Medico
    }
}
