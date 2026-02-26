<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KelolaKost extends Model
{
    protected $fillable = [
        'nama', 'alamat', 'jenis', 'harga', 'fasilitas', 'gambar', 'status'
    ];

    // Penting: Agar fasilitas otomatis terbaca sebagai array
    protected $casts = [
        'fasilitas' => 'array'
    ];
}
