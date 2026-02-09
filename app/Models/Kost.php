<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kost extends Model
{
    use HasFactory;

    // Kolom yang boleh diisi mass assignment
    protected $fillable = [
        'nama',
        'alamat',
        'lokasi',
        'harga',
        'foto',
        'fasilitas'
    ];

    // Cast JSON → array otomatis
    protected $casts = [
        'fasilitas' => 'array'
    ];
}
