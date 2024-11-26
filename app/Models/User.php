<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    protected $fillable = [
        'name', 'email', 'password', 'role',
    ];

    // Menambahkan metode untuk mengecek role
    public function isKaryawan()
    {
        return $this->role === 'karyawan';
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }
}
