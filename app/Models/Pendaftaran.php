<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use App\Models\User;

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
        'user_id',
    ];

    public function kuota()
    {
        return $this->belongsTo(Kuota::class);
    }

    public function suratUploads()
    {
        return $this->hasMany(SuratUpload::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Route notifications for the mail channel.
     */
    public function routeNotificationForMail($notification)
    {
        return $this->email;
    }

    /**
     * Accessor for tgl_mulai to map to tanggal_mulai_pkl
     */
    public function getTglMulaiAttribute()
    {
        return $this->tanggal_mulai_pkl;
    }

    /**
     * Accessor for tgl_selesai to map to tanggal_selesai_pkl
     */
    public function getTglSelesaiAttribute()
    {
        return $this->tanggal_selesai_pkl;
    }

}
