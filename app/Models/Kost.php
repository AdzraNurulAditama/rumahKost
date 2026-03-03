<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kost extends Model
{
    protected $fillable = [
        'nama',
        'alamat',
        'lokasi',
        'jenis',
        'harga',
        'fasilitas',
        'status'
    ];

    protected $casts = [
    'fasilitas' => 'array',
    ];

    public function images()
    {
        return $this->hasMany(KostImage::class, 'kost_id');
    }
}