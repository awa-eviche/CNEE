<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope; 
use Illuminate\Mail\Mailables\Content;

class RejeterEntrepriseMail extends Mailable
{
    use Queueable, SerializesModels;

    public $entreprise; // Variable publique pour partager les données avec la vue
    public $motif; // Ajouter une variable pour le motif

    public function __construct($entreprise, $motif) // Modifier le constructeur
    {
        $this->entreprise = $entreprise; 
        $this->motif = $motif; // Initialiser le motif
    }

    public function envelope()
    {
        return new Envelope(
            subject: config('constants.emails.entreprise_rejeter') . ' Rejet CNEE',
        );
    }

    public function build()
    {
        return $this->view('emails.entreprise_rejeter')
                    ->with([
                        'entreprise' => $this->entreprise,
                        'motif' => $this->motif, // Passer le motif à la vue
                    ]);
    }

    public function attachments()
    {
        return [];
    }
}
