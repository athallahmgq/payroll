<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // Tambahkan role
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array // Untuk Laravel 10+
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed', // Otomatis hash saat di-set
        ];
    }

    // Relasi ke Karyawan
    public function karyawan()
    {
        return $this->hasOne(Karyawan::class);
    }

    public function isAdmin()
{
    return $this->role === 'admin';
}
}
