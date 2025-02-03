<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope; // Utilisation correcte de la classe Envelope
use Illuminate\Mail\Mailables\Content;
class EntrepriseInscriteMail extends Mailable
{
    use Queueable, SerializesModels;

    public $entreprise; // Variable publique pour partager les données avec la vue

    /**
     * Create a new message instance.
     *
     * @param mixed $entreprise
     */
    public function __construct($entreprise)
    {
        $this->entreprise = $entreprise; 
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new \Illuminate\Mail\Mailables\Envelope(
            subject: config('constants.emails.entreprise_inscrite') . ' Inscription CNEE',
          
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function build()
{
    return $this->view('emails.entreprise_inscrite')
                ->with([
                    'entreprise' => $this->entreprise,
                ]);
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
