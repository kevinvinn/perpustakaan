<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalPetugas extends Model
{
    use HasFactory;

    protected $table = 'jadwal_petugas';

    protected $fillable = [
        'petugas_id',
        'tanggal',
        'shift',
    ];

    // Relasi ke tabel users
    public function petugas()
    {
        return $this->belongsTo(User::class, 'petugas_id');
    }
}
