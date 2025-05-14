<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon; // Untuk bekerja dengan tanggal
use App\Models\Absensi; // Sesuaikan dengan nama model Absensi Anda
use App\Http\Controllers\Controller; // Biasanya controller meng-extend Controller dasar
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Menampilkan halaman dashboard admin.
     *
     * @return \Illuminate\View\View
     */
    public function index() // PASTIKAN METHOD INI ADA
    {
        $totalKaryawan = \App\Models\Karyawan::count(); // Contoh
        $tanggalHariIni = Carbon::today();
        $totalAbsensiHariIni = Absensi::whereDate('created_at', $tanggalHariIni)->count(); // Atau logika Anda

        return view('admin.dashboard', [
            'totalKaryawan' => $totalKaryawan,
            'totalAbsensiHariIni' => $totalAbsensiHariIni
]);

// Atau menggunakan compact():
// return view('admin.dashboard', compact('totalKaryawan', 'totalAbsensiHariIni'));

       return view('admin.dashboard')->with('totalKaryawan', $totalKaryawan);
    }

    // Anda bisa menambahkan method lain di sini jika diperlukan
}

