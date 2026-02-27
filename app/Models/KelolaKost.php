<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kosts extends Model
{
    protected $fillable = [
        'nama', 'alamat', 'jenis', 'harga', 'fasilitas', 'lokasi', 'gambar', 'status'
    ];

    // Penting: Agar fasilitas otomatis terbaca sebagai array
    protected $casts = [
        'fasilitas' => 'array'
    ];
}
