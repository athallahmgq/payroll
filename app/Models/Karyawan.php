<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    use HasFactory;
    protected $table = 'karyawan'; // Eksplisit jika perlu
    protected $fillable = [
        'user_id', 'nik', 'alamat', 'no_telepon', 'posisi',
        'tanggal_masuk', 'gaji_pokok',
    ];

    public function user() { return $this->belongsTo(User::class); }
    public function absensi() { return $this->hasMany(Absensi::class); }
    public function gaji() { return $this->hasMany(Gaji::class); }

    public function getNamaAttribute()
{
   
    if ($this->relationLoaded('user') && $this->user) {
        return $this->user->name;
    } elseif ($this->user_id) {
        
        $user = User::find($this->user_id);
        return $user ? $user->name : 'Nama tidak tersedia';
    }
    return 'Nama tidak tersedia';
}
}
