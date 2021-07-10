<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendTokenRegistrationMail extends Notification implements ShouldQueue
{
    use Queueable;

    public $token;
    public $idCourse;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(string $token, int $idCourse)
    {
        $this->token = $token;
        $this->idCourse = $idCourse;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
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
        $webUrl = config('app.web_url') . "/course-registrations/$this->idCourse" . '?token=' . $this->token;

        return (new MailMessage)
            ->line('Click the button below to see details')
            ->action('Click here', $webUrl)
            ->line('Thank you for using our application!');
    }
}
