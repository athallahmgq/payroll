<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Karyawan; // Pastikan Karyawan di-import
use Illuminate\Http\Request;
use Carbon\Carbon; // Jika menggunakan Carbon untuk filter tanggal

class AbsensiController extends Controller
{
    public function index(Request $request)
    {
        $karyawans = Karyawan::with('user')->orderBy('nik')->get();
        $selectedKaryawanId = $request->input('karyawan_id');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $selectedBulan = $request->input('bulan', date('m')); // Ambil bulan dari request, default bulan ini
        $selectedTahun = $request->input('tahun', date('Y')); // Ambil tahun dari request, default tahun ini

        $query = Absensi::query()->with('karyawan.user');

        if ($selectedKaryawanId) {
            $query->where('karyawan_id', $selectedKaryawanId);
        }

        // Prioritaskan filter rentang tanggal jika ada
        if ($startDate && $endDate) {
            try {
                $start = Carbon::parse($startDate)->startOfDay();
                $end = Carbon::parse($endDate)->endOfDay();
                // GUNAKAN NAMA KOLOM YANG BENAR: 'tanggal'
                $query->whereBetween('tanggal', [$start, $end]);
            } catch (\Exception $e) {
                // Tangani error parsing tanggal atau beri feedback ke user
            }
        } elseif ($startDate) { // Jika hanya tanggal mulai
            try {
                $start = Carbon::parse($startDate)->startOfDay();
                $query->where('tanggal', '>=', $start);
            } catch (\Exception $e) {}
        } elseif ($endDate) { // Jika hanya tanggal akhir
             try {
                $end = Carbon::parse($endDate)->endOfDay();
                $query->where('tanggal', '<=', $end);
            } catch (\Exception $e) {}
        } else {
            // Jika tidak ada filter rentang tanggal, filter berdasarkan bulan dan tahun yang dipilih
            // (atau yang default jika tidak ada input)
            if ($selectedBulan && $selectedTahun) {
                $query->whereMonth('tanggal', $selectedBulan)
                      ->whereYear('tanggal', $selectedTahun);
            }
        }


        $listBulan = [
            '01' => 'Januari', '02' => 'Februari', '03' => 'Maret',
            '04' => 'April',   '05' => 'Mei',      '06' => 'Juni',
            '07' => 'Juli',    '08' => 'Agustus',  '09' => 'September',
            '10' => 'Oktober', '11' => 'November', '12' => 'Desember',
        ];

        // Buat list tahun dari beberapa tahun lalu hingga tahun ini
        $listTahun = [];
        $tahunAwal = date('Y') - 5; // Contoh: 5 tahun ke belakang
        for ($tahun = date('Y'); $tahun >= $tahunAwal; $tahun--) {
            $listTahun[$tahun] = $tahun;
        }


        // Variabel $absensi ini adalah hasil paginasi
        $absensi = $query->orderBy('tanggal', 'desc') // Gunakan 'tanggal'
                         ->orderBy('karyawan_id')
                         ->paginate(20); // Pastikan Anda selalu memanggil paginate() di sini

        // Hapus $absensiList = Absensi::all(); jika tidak digunakan secara spesifik di view.
        // Variabel $absensi di atas sudah cukup untuk menampilkan daftar dan paginasi.

        return view('admin.absensi.index', compact(
            'absensi',              // Ini adalah Paginator
            'karyawans',
            'selectedKaryawanId',
            'startDate',
            'endDate',
            'selectedBulan',        // Kirim bulan yang terpilih
            'listBulan',
            'selectedTahun',        // Kirim tahun yang terpilih
            'listTahun'
        ));
    }
}