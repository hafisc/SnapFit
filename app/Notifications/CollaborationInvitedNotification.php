<?php

namespace App\Notifications;

use App\Models\CocreateRoom;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CollaborationInvitedNotification extends Notification
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
        $creatorName = $this->room->creator->name ?? 'Seorang Pengguna';
        
        // Tentukan URL dashboard sesuai role penerima
        $url = url('/profile');
        if ($notifiable->active_role === 'umkm') {
            $url = url('/umkm/cocreate');
        } elseif ($notifiable->active_role === 'designer' || $notifiable->active_role === 'desainer') {
            $url = url('/designer/cocreate');
        }

        return (new MailMessage)
            ->subject('Undangan Kolaborasi Baru di SnapFit 👥')
            ->greeting('Halo, ' . $notifiable->name . '!')
            ->line($creatorName . ' telah mengajak Anda untuk berkolaborasi dalam mendesain produk di SnapFit.')
            ->line('Nama Proyek: ' . $this->room->name)
            ->line('Deskripsi: ' . ($this->room->description ?: 'Tidak ada deskripsi.'))
            ->action('Tinjau Undangan Kolaborasi', $url)
            ->line('Silakan masuk ke akun SnapFit Anda untuk menyetujui atau menolak ajakan kolaborasi ini.')
            ->salutation('Salam hangat, Tim SnapFit');
    }
}
