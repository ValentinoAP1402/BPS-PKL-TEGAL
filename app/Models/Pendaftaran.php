<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Pendaftaran extends Model
{
    use Notifiable;

    protected $fillable = [
        'nama_lengkap',
        'asal_sekolah',
        'jurusan',
        'email',
        'no_hp',
        'surat_keterangan_pkl',
        'surat_tanda_tangan',
        'surat_mitra_signed',
        'surat_balasan_pkl',
        'tanggal_mulai_pkl',
        'tanggal_selesai_pkl',
        'kuota_id', // Pastikan 'kuota_id' ada untuk relasi dengan Kuota
        'status', // Pastikan 'status' juga ada jika Anda mengaturnya di form atau ingin defaultnya terisi
    ];

    public function kuota()
    {
        return $this->belongsTo(Kuota::class);
    }

    public function suratUploads()
    {
        return $this->hasMany(SuratUpload::class);
    }

    /**
     * Route notifications for the mail channel.
     */
    public function routeNotificationForMail($notification)
    {
        return $this->email;
    }

}
