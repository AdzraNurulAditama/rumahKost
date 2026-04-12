<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KostVideo extends Model
{
    protected $table = 'kost_videos';
    protected $fillable = ['kost_id', 'video', 'judul'];

    public function kost()
    {
        return $this->belongsTo(Kost::class);
    }
}