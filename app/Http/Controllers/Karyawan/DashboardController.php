<?php

namespace App\Http\Controllers\Karyawan;

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Absensi;
use App\Models\Karyawan; // Tambahkan ini
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if ($user->role !== 'karyawan') { // Double check role
            Auth::logout();
            return redirect()->route('login')->with('error', 'Akses tidak sah.');
        }

        $karyawan = $user->karyawan;
        if (!$karyawan) {
            // Arahkan ke halaman untuk melengkapi data profil karyawan
            return redirect()->route('karyawan.profile.complete.form')
                             ->with('info', 'Harap lengkapi data profil karyawan Anda terlebih dahulu.');
        }

        $absensiHariIni = Absensi::where('karyawan_id', $karyawan->id)
                                ->whereDate('tanggal', today())->first();
        $riwayatTerakhir = Absensi::where('karyawan_id', $karyawan->id)
                                 ->orderBy('tanggal', 'desc')->take(5)->get();

        return view('karyawan.dashboard', compact('karyawan', 'absensiHariIni', 'riwayatTerakhir'));
    }

    // Method untuk form melengkapi profil karyawan
    public function completeProfileForm()
    {
        // Cek apakah profil sudah ada, jika iya redirect
        if (Auth::user()->karyawan) {
            return redirect()->route('karyawan.dashboard');
        }
        return view('karyawan.profile.complete'); // Buat view ini
    }

    // Method untuk menyimpan profil karyawan yang dilengkapi
    public function saveCompleteProfile(Request $request)
    {
        $user = Auth::user();
        if ($user->karyawan) { // Sudah ada, jangan buat lagi
            return redirect()->route('karyawan.dashboard')->with('warning', 'Profil karyawan sudah ada.');
        }

        $request->validate([
            'nik' => ['required', 'string', 'max:20', 'unique:karyawan,nik'],
            'posisi' => ['required', 'string', 'max:100'],
            'tanggal_masuk' => ['required', 'date'],
            'gaji_pokok' => ['required', 'numeric', 'min:0'],
            'alamat' => ['nullable', 'string'],
            'no_telepon' => ['nullable', 'string', 'max:15'],
        ]);

        Karyawan::create([
            'user_id' => $user->id,
            'nik' => $request->nik,
            'posisi' => $request->posisi,
            'tanggal_masuk' => $request->tanggal_masuk,
            'gaji_pokok' => $request->gaji_pokok,
            'alamat' => $request->alamat,
            'no_telepon' => $request->no_telepon,
        ]);

        return redirect()->route('karyawan.dashboard')->with('success', 'Profil karyawan berhasil disimpan.');
    }
}
