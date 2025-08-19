<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Sanctum\HasApiTokens; // penting untuk token

class User extends Model
{
    use HasFactory, HasApiTokens; // tambahkan HasApiTokens

    // Nama tabel
    protected $table = 'users';

    // Kolom yang bisa diisi massal
    protected $fillable = [
        'nama',
        'email',
        'password',
        'role',
    ];

    // Timestamps aktif
    public $timestamps = true;

    // Hash password otomatis saat disimpan
    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }
}
