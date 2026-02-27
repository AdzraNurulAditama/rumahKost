<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kost extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'alamat',
        'lokasi',
        'harga',
        'foto',
        'fasilitas'
    ];

    protected $casts = [
        'fasilitas' => 'array'
    ];
    public function images()
{
    return $this->hasMany(KostImage::class);
}
}
