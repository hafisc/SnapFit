<?php

namespace App\Notifications;

use App\Models\CocreateRoom;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CollaborationAcceptedNotification extends Notification
{
    use Queueable;

    protected $room;

    /**
     * Create a new notification instance.
     */
    public function __construct(CocreateRoom $room)
    {
        $this->room = $room;
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
        // Penerima (notifiable) adalah creator (Desainer/UMKM yang mengajak).
        // Kita butuh nama orang yang menyetujui (invitedUser).
        $invitedName = $this->room->invitedUser->name ?? 'Kolaborator';

        // Tentukan URL room sesuai role pembuat (creator)
        $url = url('/profile');
        if ($notifiable->active_role === 'umkm') {
            $url = url('/umkm/cocreate/' . $this->room->id);
        } elseif ($notifiable->active_role === 'designer' || $notifiable->active_role === 'desainer') {
            $url = url('/designer/cocreate/' . $this->room->id);
        }

        return (new MailMessage)
            ->subject('Kolaborasi Co-Create Disetujui! 🎉')
            ->greeting('Halo, ' . $notifiable->name . '!')
            ->line('Kabar baik! ' . $invitedName . ' telah menyetujui ajakan kolaborasi Anda.')
            ->line('Nama Proyek: ' . $this->room->name)
            ->action('Mulai Desain Sekarang', $url)
            ->line('Klik tombol di atas untuk langsung masuk ke ruang kerja real-time bersama kolaborator Anda.')
            ->salutation('Salam hangat, Tim SnapFit');
    }
}
