<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OtpCodeMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $code,
        public string $intentLabel
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Votre code de connexion — Alliance',
        );
    }

    public function content(): Content
    {
        return new Content(
            html: 'emails.otp-code-html',
        );
    }
}
