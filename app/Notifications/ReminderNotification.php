<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ReminderNotification extends Notification
{
    use Queueable;

    protected $reminder;

    public function __construct($reminder)
    {
        $this->reminder = $reminder;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
        {
            return (new MailMessage)
                        ->subject('Recordatorio de evento')
                        ->line('Tienes un recordatorio para el evento: ' . $this->reminder->event->title)
                        ->action('Ver Evento', url('/events/' . $this->reminder->event->id))
                        ->line('Gracias por usar nuestra aplicación!');
        }

}

