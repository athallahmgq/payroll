<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gaji extends Model
{
    use HasFactory;
    protected $table = 'gaji';
    protected $fillable = [
        'karyawan_id', 'bulan', 'tahun', 'total_hadir', 'total_izin',
        'total_sakit', 'total_tanpa_keterangan', 'gaji_pokok', 'potongan',
        'gaji_bersih', 'keterangan', 'tanggal_pembayaran',
    ];

    public function karyawan() 
    { 
        return $this->belongsTo(Karyawan::class); 
    }

    public function user()
{
    return $this->belongsTo(User::class, 'karyawan_id', 'id');
}
}
