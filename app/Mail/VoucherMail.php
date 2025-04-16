<?php

namespace App\Mail;

use App\Models\Agendamento;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class VoucherMail extends Mailable
{
    use Queueable, SerializesModels;

    public $agendamento;

    /**
     * Cria uma nova instância da mensagem.
     */
    public function __construct(Agendamento $agendamento)
    {
        $this->agendamento = $agendamento;
    }

    /**
     * Define o envelope da mensagem.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Seu Voucher de Agendamento',
        );
    }

    /**
     * Define o conteúdo do e-mail.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.voucher',
        );
    }

    /**
     * Define os anexos do e-mail.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
