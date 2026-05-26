<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ResetPasswordNotification extends Notification
{
    use Queueable;

    /**
     * The password reset token.
     *
     * @var string
     */
    public $token;

    /**
     * Create a new notification instance.
     */
    public function __construct(string $token)
    {
        $this->token = $token;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $url = url('/password/reset/' . $this->token . '?email=' . urlencode($notifiable->getEmailForPasswordReset()));

        return (new MailMessage)
            ->subject('Reset Kata Sandi Akun SnapFit')
            ->greeting('Halo, ' . $notifiable->name . '!')
            ->line('Anda menerima email ini karena kami menerima permintaan reset kata sandi untuk akun Anda.')
            ->action('Reset Kata Sandi', $url)
            ->line('Link reset kata sandi ini akan kedaluwarsa dalam 60 menit.')
            ->line('Jika Anda tidak merasa melakukan permintaan ini, silakan abaikan email ini.')
            ->salutation('Salam hangat, Tim SnapFit');
    }
}
