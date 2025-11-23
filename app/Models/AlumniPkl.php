<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlumniPkl extends Model
{
    use HasFactory;

    protected $table = 'alumni_pkl';

    protected $fillable = [
        'nama_lengkap',
        'universitas',
        'foto',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
