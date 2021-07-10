<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SussessRegistrationEmail extends Notification implements ShouldQueue
{
    use Queueable;

    public $idCourse;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(int $idCourse)
    {
        $this->idCourse = $idCourse;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->line('Sussess Course Registration')
            ->line('Id: ' . $this->idCourse)
            ->line('Thank you for using our application!');
    }
}
