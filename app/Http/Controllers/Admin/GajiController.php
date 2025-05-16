<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Karyawan;
use App\Models\Gaji;
use App\Models\Absensi;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class GajiController extends Controller
{
    public function index()
    {
        $karyawans = Karyawan::all();
        $gajis = Gaji::with('karyawan')->orderBy('tahun', 'desc')
            ->orderBy('bulan', 'desc')
            ->get();
            
        $bulanList = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember'
        ];
        
        // Tahun saat ini dan 2 tahun sebelumnya
        $tahunList = [];
        $currentYear = Carbon::now()->year;
        for ($i = $currentYear - 2; $i <= $currentYear; $i++) {
            $tahunList[$i] = $i;
        }
        
        return view('admin.gaji.index', compact('karyawans', 'gajis', 'bulanList', 'tahunList'));
    }
    
    public function hitungDanSimpan(Request $request)
    {
        $request->validate([
            'bulan' => 'required|integer|between:1,12',
            'tahun' => 'required|integer|min:2000|max:' . (date('Y') + 1),
            'karyawan_id' => 'required|exists:karyawan,id',
        ]);
        
        $karyawanId = $request->karyawan_id;
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        
        // Cek apakah data gaji sudah ada
        $existingGaji = Gaji::where('karyawan_id', $karyawanId)
            ->where('bulan', $bulan)
            ->where('tahun', $tahun)
            ->first();
            
        if ($existingGaji) {
            return redirect()->route('admin.gaji.index')
                ->with('error', 'Data gaji untuk karyawan ini pada periode tersebut sudah ada');
        }
        
        // Ambil data karyawan
        $karyawan = Karyawan::findOrFail($karyawanId);
        $gajiPokok = $karyawan->gaji_pokok;
        
        // Hitung jumlah kehadiran
        $startDate = Carbon::createFromDate($tahun, $bulan, 1)->startOfMonth();
        $endDate = Carbon::createFromDate($tahun, $bulan, 1)->endOfMonth();
        
        $absensi = Absensi::where('karyawan_id', $karyawanId)
            ->whereBetween('tanggal', [$startDate, $endDate])
            ->get();
            
        // Hitung total hadir, izin, sakit, dan tanpa keterangan
        $totalHadir = $absensi->where('status', 'hadir')->count();
        $totalIzin = $absensi->where('status', 'izin')->count();
        $totalSakit = $absensi->where('status', 'sakit')->count();
        
        // Hitung hari kerja dalam sebulan (asumsi Senin-Jumat)
        $workingDays = 0;
        $date = clone $startDate;
        while ($date <= $endDate) {
            $dayOfWeek = $date->dayOfWeek;
            // 0 = Minggu, 6 = Sabtu
            if ($dayOfWeek != 0 && $dayOfWeek != 6) {
                $workingDays++;
            }
            $date->addDay();
        }
        
        // Hitung total ketidakhadiran tanpa keterangan
        // (hari kerja - (hadir + izin + sakit))
        $totalTanpaKeterangan = $workingDays - ($totalHadir + $totalIzin + $totalSakit);
        if ($totalTanpaKeterangan < 0) $totalTanpaKeterangan = 0;
        
        // Hitung potongan (50,000 per ketidakhadiran tanpa keterangan)
        $potongan = $totalTanpaKeterangan * 50000;
        
        // Hitung gaji bersih
        $gajiBersih = $gajiPokok - $potongan;
        
        // Simpan data gaji
        $gaji = new Gaji();
        $gaji->karyawan_id = $karyawanId;
        $gaji->bulan = $bulan;
        $gaji->tahun = $tahun;
        $gaji->total_hadir = $totalHadir;
        $gaji->total_izin = $totalIzin;
        $gaji->total_sakit = $totalSakit;
        $gaji->total_tanpa_keterangan = $totalTanpaKeterangan;
        $gaji->gaji_pokok = $gajiPokok;
        $gaji->potongan = $potongan;
        $gaji->gaji_bersih = $gajiBersih;
        $gaji->tanggal_pembayaran = Carbon::now();
        $gaji->save();
        
        return redirect()->route('admin.gaji.index')
            ->with('success', 'Penghitungan gaji berhasil disimpan');
    }

    public function cetak($id)
    {
        $gaji = Gaji::with('karyawan')->findOrFail($id);
        $bulanList = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember'
        ];
        
        return view('admin.gaji.cetak', compact('gaji', 'bulanList'));
    }
}