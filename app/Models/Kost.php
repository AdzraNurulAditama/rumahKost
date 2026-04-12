<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kost extends Model
{
    protected $fillable = [
    'nama', 'alamat', 'lokasi', 'jenis', 'harga', 'fasilitas', 'status', 'jumlah_kamar' // ✅ TAMBAH
];

    protected $casts = [
        'fasilitas' => 'array'
    ];

    public function images()
    {
        return $this->hasMany(KostImage::class);
    }

    public function videos()
    {
        return $this->hasMany(KostVideo::class);
    }
    public function kamars()
    {
        return $this->hasMany(Kamar::class, 'kost_id');
    }
    
    public function penyewas()
    {
        return $this->hasMany(Penyewa::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}