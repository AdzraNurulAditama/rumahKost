<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penyewa extends Model
{
    use HasFactory;

    protected $table = 'penyewas';

    protected $fillable = [
        'nama_lengkap',
        'email',
        'nomor_telepon',
        'no_kamar',
        'nama_kost',
        'status',
        'foto'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}