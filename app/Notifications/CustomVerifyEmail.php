<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CustomVerifyEmail extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via($notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable): MailMessage
    {
        // Gera a URL de verificação do e-mail
        $verificationUrl = $this->verificationUrl($notifiable);

        // Retorna a estrutura do e-mail
        return (new MailMessage)
            ->subject('🚀 Confirme seu e-mail na MedExame!')
            ->greeting('Olá, seja bem-vindo(a)! 👋')
            ->line('Estamos quase lá! Para ativar sua conta na MedExame, clique no botão abaixo:')
            ->action('✅ Confirmar E-mail', $verificationUrl)
            ->line('Se você não criou esta conta, pode ignorar este e-mail. Nenhuma ação adicional é necessária.')
            ->salutation('Atenciosamente, Equipe MedExame 🚀');
    }

    /**
     * Get the verification URL for the user.
     *
     * @param  mixed  $notifiable
     * @return string
     */
    protected function verificationUrl($notifiable)
    {
        // Gerar a URL de verificação do usuário
        return $notifiable->verificationUrl();
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array<string, mixed>
     */
    public function toArray($notifiable): array
    {
        return [
            //
        ];
    }
}
