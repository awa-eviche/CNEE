<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class NouvelleEntrepriseNotification extends Notification
{
    use Queueable;

    protected $entreprise;

    /**
     * Créez une nouvelle instance de la notification.
     *
     * @param  \App\Models\Entreprise  $entreprise
     * @return void
     */
    public function __construct($entreprise)
    {
        $this->entreprise = $entreprise;
    }

    /**
     * Détermine les canaux par lesquels la notification sera envoyée.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        // Ici, nous envoyons uniquement un e-mail.
        return ['mail', 'database'];
    }

    /**
     * Crée le message e-mail de la notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Nouvelle entreprise enregistrée')
                    ->line('Une nouvelle entreprise, ' . $this->entreprise->nomentreprise . ', vient de s\'enregistrer sur votre plateforme.')
                    ->action('Voir l\'entreprise', url('/entreprise/' . $this->entreprise->id))
                    ->line('Merci de vérifier et de valider l\'entreprise.');
    }

    public function toDatabase($notifiable)
    {
        return [
            'entreprise_id' => $this->entreprise->id,
            'nomentreprise' => $this->entreprise->nomentreprise,
            'message'       => 'Nouvelle entreprise enregistrée.',
        ];
    }
}
