<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Auth extends Model
{
    use HasApiTokens;

    // Bisa ditujukan ke tabel users
    protected $table = 'users';

    // Kolom yang bisa diisi massal
    protected $fillable = [
        'nama',
        'email',
        'password',
        'role',
    ];

    // Jangan lupa hash password sebelum disimpan
    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }

    // Timestamps tetap aktif
    public $timestamps = true;
}
