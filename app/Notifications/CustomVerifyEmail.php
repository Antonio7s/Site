<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Support\Facades\URL;

class CustomVerifyEmail extends VerifyEmail
{
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Verifique seu endereço de email')
            ->line('Por favor, clique no botão abaixo para verificar seu email.')
            ->action('Verificar Email', $this->verificationUrl($notifiable))
            ->line('Se você não criou uma conta, ignore este email.');
    }

    // Método corrigido usando a implementação do Laravel
    protected function verificationUrl($notifiable)
    {
        return URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(config('auth.verification.expire', 60)),
            [
                'id' => $notifiable->getKey(),
                'hash' => sha1($notifiable->getEmailForVerification()),
            ]
        );
    }
}