<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    protected $table = 'buku';

    protected $fillable = [
        'judul',
        'kategori_id',
        'stok',
        'tahun_terbit',
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }
}
