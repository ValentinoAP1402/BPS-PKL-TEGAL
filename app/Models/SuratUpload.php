<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratUpload extends Model
{
    use HasFactory;

    protected $fillable = [
        'pendaftaran_id',
        'file_path',
        'file_name',
        'file_type',
        'file_size',
        'surat_mitra_signed',
    ];

    public function pendaftaran()
    {
        return $this->belongsTo(Pendaftaran::class);
    }
}
