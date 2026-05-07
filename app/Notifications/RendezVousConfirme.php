<?php

namespace App\Notifications;

use App\Models\RendezVous;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class RendezVousConfirme extends Notification
{
    use Queueable;

    public RendezVous $rdv;

    public function __construct(RendezVous $rdv)
    {
        $this->rdv = $rdv;
    }

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Confirmation de votre Rendez-vous Medical')
            ->greeting('Bonjour ' . $notifiable->name . ',')
            ->line('Votre rendez-vous a ete confirme avec succes.')
            ->line('Medecin : Dr. ' . $this->rdv->medecin->nom . ' ' . $this->rdv->medecin->prenom)
            ->line('Specialite : ' . $this->rdv->medecin->specialite)
            ->line('Date : ' . $this->rdv->date->format('d/m/Y'))
            ->line('Heure : ' . $this->rdv->heure)
            ->line('Motif : ' . $this->rdv->motif)
            ->action('Voir mes rendez-vous', url('/rendezvous/index.blade.php'))
            ->line('Merci de vous presenter 10 minutes avant votre rendez-vous.')
            ->salutation('Cordialement, RDV Medical');
    }
}