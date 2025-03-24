<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CandidatureStatusChanged extends Notification implements ShouldQueue
{
    use Queueable;

    protected $candidature;

    public function __construct($candidature)
    {
        $this->candidature = $candidature;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Statut de votre candidature mis à jour')
            ->line('Le statut de votre candidature pour l\'annonce "'.$this->candidature->annonce->title.'" a été mis à jour.')
            ->line('Nouveau statut: '.$this->candidature->status)
            ->action('Voir la candidature', url('/candidatures/'.$this->candidature->id))
            ->line('Merci d\'utiliser notre plateforme!');
    }
}