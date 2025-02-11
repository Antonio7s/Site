<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'access_level',
        'photo', // Adicionando o campo 'photo'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Método para retornar a URL da foto do usuário
    public function getPhotoUrlAttribute()
    {
        // Verifica se o usuário tem uma foto, caso contrário, retorna uma imagem padrão
        return $this->photo ? asset('storage/' . $this->photo) : asset('images/default-photo.png');
    }
}
