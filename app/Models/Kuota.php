<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kuota extends Model
{
    protected $fillable = [
        'bulan',
        'jumlah_kuota',
    ];

    public function pendaftarans()
    {
        return $this->hasMany(Pendaftaran::class);
    }

    /**
     * Get the number of available slots for this quota
     */
    public function getAvailableSlotsAttribute()
    {
        return $this->jumlah_kuota - $this->pendaftarans()->where('status', 'approved')->count();
    }

    /**
     * Check if quota is available
     */
    public function isAvailable()
    {
        return $this->available_slots > 0;
    }
}
