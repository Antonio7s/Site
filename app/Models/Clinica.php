<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; //SEED

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Clinica extends Authenticatable //implements MustVerifyEmail
{
    use Notifiable;
    use HasFactory;

    // Definindo a tabela que a Clínica usa (caso seja diferente do padrão 'clinicas')
    protected $table = 'clinicas';

    // Campos preenchíveis (os que podem ser atribuídos em massa)
    protected $fillable = [
        'status', // [pendente, aprovado, negado]
        'razao_social', // Novo campo para a Razão Social
        'nome_fantasia', // Novo campo para o Nome Fantasia
        'cnpj_cpf', // Novo campo para CNPJ ou CPF
        'email',
        'password',
        'documentos', // caminho do arquivo
        'wallet_id',
        'porcentagem_lucro',
        'valor_fixo_lucro',
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
