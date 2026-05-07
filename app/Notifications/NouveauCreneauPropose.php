<?php

namespace App\Notifications;

use App\Models\RendezVous;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class NouveauCreneauPropose extends Notification
{
    use Queueable;

    public function __construct(
        public RendezVous $rdv,
        public string $ancienneDate,
        public string $ancienneHeure,
        public string $message
    ) {}

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Modification de votre Rendez-vous Medical')
            ->greeting('Bonjour ' . $notifiable->name . ',')
            ->line('Votre medecin a propose un nouveau creneau pour votre rendez-vous.')
            ->line('---')
            ->line('Ancien creneau : ' . $this->ancienneDate . ' a ' . $this->ancienneHeure)
            ->line('Nouveau creneau : ' . $this->rdv->date->format('d/m/Y') . ' a ' . $this->rdv->heure)
            ->line('Medecin : Dr. ' . $this->rdv->medecin->nom . ' ' . $this->rdv->medecin->prenom)
            ->line('Message du medecin : ' . $this->message)
            ->action('Voir mes rendez-vous', url('/rendezvous'))
            ->line('Merci de confirmer votre presence ou de nous contacter.')
            ->salutation('Cordialement, RDV Medical');
    }
}