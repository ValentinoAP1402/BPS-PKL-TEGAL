<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PendaftaranStatusNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $pendaftaran;
    protected $status;

    /**
     * Create a new notification instance.
     */
    public function __construct($pendaftaran, $status)
    {
        $this->pendaftaran = $pendaftaran;
        $this->status = $status;
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
        $subject = 'Update Status Pendaftaran PKL';
        $message = (new MailMessage)
                    ->subject($subject)
                    ->greeting('Halo ' . $this->pendaftaran->nama_lengkap . ',');

        if ($this->status == 'approved') {
            $message->line('Selamat! Pendaftaran PKL Anda telah disetujui.')
                    ->line('Detail Pendaftaran:')
                    ->line('Nama: ' . $this->pendaftaran->nama_lengkap)
                    ->line('Asal Universitas/Sekolah: ' . $this->pendaftaran->asal_sekolah)
                    ->line('Jurusan: ' . $this->pendaftaran->jurusan)
                    ->line('Tanggal Mulai: ' . $this->pendaftaran->tanggal_mulai_pkl)
                    ->line('Tanggal Selesai: ' . $this->pendaftaran->tanggal_selesai_pkl)
                    ->action('Lihat Profil', url('/profile'))
                    ->line('Terima kasih telah mendaftar PKL di BPS!');
        } elseif ($this->status == 'rejected') {
            $message->line('Maaf, pendaftaran PKL Anda telah ditolak.')
                    ->line('Silakan hubungi admin untuk informasi lebih lanjut.')
                    ->action('Lihat Profil', url('/profile'))
                    ->line('Terima kasih.');
        } elseif ($this->status == 'completed') {
            $message->line('Selamat! PKL Anda telah selesai.')
                    ->line('Terima kasih atas partisipasi Anda.')
                    ->action('Lihat Profil', url('/profile'))
                    ->line('Sampai jumpa di kesempatan berikutnya!');
        }

        return $message;
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
            'status' => $this->status,
            'nama' => $this->pendaftaran->nama_lengkap,
        ];
    }
}
