<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penyewa extends Model
{
    protected $table = 'penyewas';

    protected $fillable = [
        'user_id',
        'kost_id',
        'kamar_id', // ✅ TAMBAH
        'jumlah_orang',
        'tgl_masuk',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function kost()
    {
        return $this->belongsTo(Kost::class);
    }

    public function kamar() // ✅ TAMBAH
    {
        return $this->belongsTo(Kamar::class);
    }

    public function pembayarans()
    {
        return $this->hasMany(Pembayaran::class);
    }
}