<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; //SEED

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable // implements MustVerifyEmail
{
    use Notifiable;
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'password',
        'access_level',
        'photo_url',
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
    
}
