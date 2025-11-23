<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SuratMitraSignedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $pendaftaran;

    /**
     * Create a new notification instance.
     */
    public function __construct($pendaftaran)
    {
        $this->pendaftaran = $pendaftaran;
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
        return (new MailMessage)
                    ->subject('Surat Ada Telah Ditandatangani')
                    ->greeting('Halo ' . $this->pendaftaran->nama_lengkap . ',')
                    ->line('Surat Anda telah ditandatangani oleh pihak BPS.')
                    ->line('Anda dapat mengunduh surat tersebut melalui website BPS PKL.')
                    ->action('Lihat Surat Mitra', url('/surat-mitra-signed'))
                    ->line('Terima kasih atas partisipasi Anda dalam program PKL di BPS!')
                    ->salutation('Salam, Tim BPS');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'pendaftaran_id' => $this->pendaftaran->id,
            'nama' => $this->pendaftaran->nama_lengkap,
            'message' => 'Surat mitra telah ditandatangani',
        ];
    }
}
