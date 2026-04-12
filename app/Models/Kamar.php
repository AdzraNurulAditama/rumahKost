<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kamar extends Model
{
    protected $fillable = [
        'kost_id', 
        'nomor_kamar', 
        'tipe_kamar', 
        'harga', 
        'status'
    ];

    public function kost()
    {
        return $this->belongsTo(Kost::class);
    }
    public function pembayarans()
{
    return $this->hasMany(Pembayaran::class);
}
}