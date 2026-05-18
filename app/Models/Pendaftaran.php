<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use App\Models\User;
use App\Models\Kuota;
use App\Models\SuratUpload;

class Pendaftaran extends Model
{
    use HasFactory, Notifiable, SoftDeletes;

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
        'kuota_id',
        'status',
        'rejection_reason',
        'user_id',
        'decided_at',
    ];

    protected $casts = [
        'decided_at' => 'datetime',
        'tanggal_mulai_pkl' => 'date',
        'tanggal_selesai_pkl' => 'date',
        'deleted_at' => 'datetime',
    ];

    /**
     * Relasi ke Kuota
     */
    public function kuota()
    {
        return $this->belongsTo(Kuota::class);
    }

    /**
     * Relasi ke Surat Upload
     */
    public function suratUploads()
    {
        return $this->hasMany(SuratUpload::class);
    }

    /**
     * Relasi ke User
     */
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
     * Accessor untuk mapping tgl_mulai
     */
    public function getTglMulaiAttribute()
    {
        return $this->tanggal_mulai_pkl;
    }

    /**
     * Accessor untuk mapping tgl_selesai
     */
    public function getTglSelesaiAttribute()
    {
        return $this->tanggal_selesai_pkl;
    }
}