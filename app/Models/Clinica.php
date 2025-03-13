<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; //SEED

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Notifications\VerifyClinicaEmail;

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

        'telefone',
        'cep',
        'endereco',
        'numero',
        'complemento',
        'bairro',
        'cidade',
        'uf',
        'email_administrativo',
        'email_faturamento',
        'telefone_local',
        'telefone_financeiro',
        'celular',
        'responsavel_nome',
        'rg',
        'orgao_emissor',
        'data_emissao',
        'responsavel_cpf',
        'estado_civil',
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

    public function sendEmailVerificationNotification()
    {
        //$this->notify(new \App\Notifications\VerifyEmailClinica());
        $this->notify(new VerifyClinicaEmail());
    }

    /**
     * Define o relacionamento de uma clínica com seus serviços diferenciados.
     */
    public function servicosDiferenciados()
    {
        return $this->hasMany(ServicoDiferenciado::class);
    }

}
