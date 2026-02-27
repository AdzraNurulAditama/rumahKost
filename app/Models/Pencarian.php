<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pencarian extends Model
{
    use HasFactory;

    protected $table = 'pencarians';

    protected $fillable = [
        'nama_kost',
        'lokasi',
        'harga',
        'fasilitas',
        'foto'
    ];
}