<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope; 
use Illuminate\Mail\Mailables\Content;

class ValiderEntrepriseMail extends Mailable
{
    use Queueable, SerializesModels;

    public $entreprise;
    public $password;

    public function __construct($entreprise, $password)
    {
        $this->entreprise = $entreprise;
        $this->password = $password;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: config('constants.emails.valider_entreprise') . ' Adhésion CNEE',
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            view: 'emails.valider_entreprise',
            with: [
                'entreprise' => $this->entreprise,
                'password' => $this->password,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}
