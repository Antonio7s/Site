<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; //SEED
use Illuminate\Database\Eloquent\Relations\HasMany; // ← Importação necessária

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use App\Notifications\CustomVerifyEmail;  // Importa notificação 

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'password',
        'access_level',
        'photo_url',
        'cpf',
        'telefone',
        'customer_id',
        'data_nascimento'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Método para retornar a URL da foto do usuário
    public function getPhotoUrlAttribute()
    {
        return isset($this->attributes['photo_url']) && $this->attributes['photo_url']
            ? asset('storage/' . $this->attributes['photo_url'])
            : asset('images/default-photo.png');
    }

    // Um paciente pode ter vários agendamentos
    public function agendamentos(): HasMany
    {
        return $this->hasMany(Agendamento::class);
    }


    /**
     * Sobrescreve a notificação de verificação de e-mail
     */
    
    public function sendEmailVerificationNotification()
    {
        $this->notify(new CustomVerifyEmail);
    }

    
}
