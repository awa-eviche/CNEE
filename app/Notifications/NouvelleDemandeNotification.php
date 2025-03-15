<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\DatabaseMessage;

class NouvelleDemandeNotification extends Notification
{
    use Queueable;

    protected $demande;

    public function __construct($demande)
    {
        $this->demande = $demande;
    }

    public function via($notifiable)
    {
        // Envoie par mail et stockage en base de données
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Nouvelle demande enregistrée')
                    ->line('La demande #' . $this->demande->id . ' vient d\'être enregistrée.')
                    ->action('Voir la demande', url('/demande/' . $this->demande->id))
                    ->line('Merci de vérifier.');
    }

    public function toDatabase($notifiable)
    {
        return [
            'demande_id' => $this->demande->id,
            'message'    => 'Nouvelle demande enregistrée.',
        ];
    }
}
