<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Karyawan;
// use Illuminate\Support\Facades\Hash; // Tidak perlu jika model User punya cast 'hashed'

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => '123', // Akan di-hash oleh model User
            'role' => 'admin',
        ]);

        // Karyawan 1
        $karyawanUser1 = User::create([
            'name' => 'Budi Karyawan',
            'email' => 'budi@example.com',
            'password' => 'password',
            'role' => 'karyawan',
        ]);
        Karyawan::create([ // Langsung create Karyawan, karena user sudah ada
            'user_id' => $karyawanUser1->id,
            'nik' => 'K001',
            'posisi' => 'Staff IT',
            'tanggal_masuk' => '2023-01-10',
            'gaji_pokok' => 5000000,
        ]);

        // Karyawan 2
        $karyawanUser2 = User::create([
            'name' => 'Siti Karyawati',
            'email' => 'siti@example.com',
            'password' => 'password',
            'role' => 'karyawan',
        ]);
        Karyawan::create([
            'user_id' => $karyawanUser2->id,
            'nik' => 'K002',
            'posisi' => 'Marketing',
            'tanggal_masuk' => '2022-06-15',
            'gaji_pokok' => 6000000,
        ]);
    }
}
