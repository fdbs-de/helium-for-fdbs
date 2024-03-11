<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ResetPasswordNotification extends Notification
{
    use Queueable;

    public $token;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($token)
    {
        $this->token = $token;
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
        return (new MailMessage)
                    ->subject('Passwort zurücksetzen')
                    ->greeting('Hallo ' . optional($notifiable)->name)
                    ->line('Sie haben Ihr Passwort vergessen? Klicken Sie auf den folgenden Link, um ein neues Passwort für Ihren Account zu vergeben:')
                    ->action('Passwort zurücksetzen', url(config('app.url').route('password.reset', ['token' => $this->token, 'email' => optional($notifiable)->email], false)))
                    ->line('Der Link ist nur 60 Minuten gültig.')
                    ->line('Sollten Sie diese Email nicht angefordert haben, ignorieren Sie diese Nachricht.')
                    ->salutation('Ihr FDBS Team');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
