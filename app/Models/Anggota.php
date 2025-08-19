<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anggota extends Model
{
    use HasFactory;

    protected $table = 'anggota'; // nama tabel
    protected $fillable = ['nama', 'jurusan', 'no_hp', 'user_id'];

    // Relasi: setiap anggota dimiliki oleh satu user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
