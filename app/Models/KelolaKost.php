<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kosts extends Model
{
    protected $fillable = [
        'nama', 'alamat', 'jenis', 'harga', 'fasilitas', 'lokasi', 'status',
    ];
    protected $casts = [
        'fasilitas' => 'array'
    ];
}
