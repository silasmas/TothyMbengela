<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewsletterConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $confirmUrl
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Confirmez votre inscription à la newsletter — Alliance',
        );
    }

    public function content(): Content
    {
        return new Content(
            html: 'emails.newsletter-confirm',
        );
    }
}
