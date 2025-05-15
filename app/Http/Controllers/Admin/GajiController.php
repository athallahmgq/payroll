<?php

// app/Http/Controllers/Admin/GajiController.php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gaji;
use App\Models\Karyawan;
use App\Models\Absensi; // Untuk menghitung kehadiran
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB; // Untuk transaksi database

class GajiController extends Controller
{
    /**
     * Menampilkan halaman utama manajemen gaji (daftar gaji yang sudah diproses/akan diproses)
     * dan form untuk memulai proses penggajian baru.
     */
    public function index(Request $request)
    {
        // Filter untuk menampilkan riwayat gaji
        $filterBulan = $request->input('bulan', date('m'));
        $filterTahun = $request->input('tahun', date('Y'));

        $riwayatGaji = Gaji::with('karyawan.user')
            ->whereMonth('periode_akhir', $filterBulan) // Atau periode_awal
            ->whereYear('periode_akhir', $filterTahun)
            ->orderBy('periode_akhir', 'desc')
            ->paginate(20);

        $listBulan = [ /* ... array bulan ... */ ];
        $listTahun = [ /* ... array tahun ... */ ];
        $karyawans = Karyawan::orderBy('nik')->get(); // Untuk opsi generate gaji per karyawan

        return view('admin.gaji.index', compact('riwayatGaji', 'listBulan', 'listTahun', 'filterBulan', 'filterTahun', 'karyawans'));
    }

    /**
     * Logika untuk menghitung dan menyimpan gaji karyawan untuk periode tertentu.
     * Ini bisa dipicu dari form di halaman index.
     */
    public function hitungDanSimpan(Request $request)
    {
        $request->validate([
            'bulan_proses' => 'required|digits:2',
            'tahun_proses' => 'required|digits:4',
            'karyawan_id' => 'nullable|exists:karyawan,id', // Opsional, untuk proses per karyawan
        ]);

        $bulan = $request->bulan_proses;
        $tahun = $request->tahun_proses;
        $karyawanIdProses = $request->karyawan_id;

        // Tentukan periode penggajian
        $periodeAwal = Carbon::createFromDate($tahun, $bulan, 1)->startOfMonth();
        $periodeAkhir = Carbon::createFromDate($tahun, $bulan, 1)->endOfMonth();

        // Ambil karyawan yang akan diproses
        $karyawansToProcess = Karyawan::query();
        if ($karyawanIdProses) {
            $karyawansToProcess->where('id', $karyawanIdProses);
        }
        $karyawans = $karyawansToProcess->where('status_aktif', true)->get(); // Asumsi ada status aktif

        if ($karyawans->isEmpty()) {
            return redirect()->back()->with('error', 'Tidak ada karyawan aktif yang ditemukan untuk diproses.');
        }

        DB::beginTransaction();
        try {
            foreach ($karyawans as $karyawan) {
                // Cek apakah gaji untuk periode & karyawan ini sudah ada
                $gajiSudahAda = Gaji::where('karyawan_id', $karyawan->id)
                                    ->where('periode_awal', $periodeAwal->toDateString())
                                    ->where('periode_akhir', $periodeAkhir->toDateString())
                                    ->exists();

                if ($gajiSudahAda) {
                    // Bisa di-skip, di-update, atau beri error. Untuk contoh, kita skip.
                    continue;
                }

                // --- MULAI PERHITUNGAN GAJI UNTUK $karyawan ---
                $gajiPokok = $karyawan->gaji_pokok; // Ambil dari data karyawan

                // 1. Hitung Kehadiran (Contoh Sederhana)
                $jumlahKehadiran = Absensi::where('karyawan_id', $karyawan->id)
                                        ->whereBetween('tanggal_absensi', [$periodeAwal, $periodeAkhir])
                                        ->where('status', 'hadir') // Atau termasuk 'terlambat'
                                        ->count();
                // Anda mungkin perlu logika jumlah hari kerja efektif dalam sebulan

                // 2. Hitung Tunjangan Tetap (Contoh Sederhana)
                // Jika Anda punya tabel komponen_gaji, ambil dari sana
                $tunjanganJabatan = 0; // Contoh, ambil dari data karyawan atau tabel lain
                $tunjanganTransport = 0; // Contoh
                $totalTunjanganTetap = $tunjanganJabatan + $tunjanganTransport;

                // 3. Hitung Tunjangan Tidak Tetap (Contoh Sederhana)
                $tunjanganKehadiran = 0;
                if ($jumlahKehadiran >= 20) { // Misal minimal 20 hari hadir
                    $tunjanganKehadiran = 100000; // Contoh nominal
                }
                $bonus = 0; // Bisa diinput manual atau dari sistem lain
                $totalTunjanganTidakTetap = $tunjanganKehadiran + $bonus;

                // 4. Hitung Gaji Kotor
                $gajiKotor = $gajiPokok + $totalTunjanganTetap + $totalTunjanganTidakTetap;

                // 5. Hitung Potongan (Contoh Sederhana)
                $potonganBPJS = $gajiPokok * 0.01; // Misal 1% dari gaji pokok
                $potonganPinjaman = 0; // Ambil dari data pinjaman jika ada
                $totalPotongan = $potonganBPJS + $potonganPinjaman;

                // 6. Hitung Gaji Bersih
                $gajiBersih = $gajiKotor - $totalPotongan;

                // --- AKHIR PERHITUNGAN GAJI ---

                Gaji::create([
                    'karyawan_id' => $karyawan->id,
                    'periode_awal' => $periodeAwal->toDateString(),
                    'periode_akhir' => $periodeAkhir->toDateString(),
                    'gaji_pokok_saat_itu' => $gajiPokok,
                    'total_tunjangan_tetap' => $totalTunjanganTetap,
                    'total_tunjangan_tidak_tetap' => $totalTunjanganTidakTetap,
                    'total_potongan' => $totalPotongan,
                    'gaji_kotor' => $gajiKotor,
                    'gaji_bersih' => $gajiBersih,
                    'jumlah_kehadiran' => $jumlahKehadiran,
                    // 'jumlah_hari_kerja' => ..., // Hitung jika perlu
                    'status_pembayaran' => 'diproses', // Awalnya 'diproses' atau 'belum_diproses'
                ]);
            }

            DB::commit();
            return redirect()->route('admin.gaji.index')
                             ->with('success', 'Proses penggajian untuk periode ' . $periodeAwal->format('M Y') . ' berhasil dijalankan.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                             ->with('error', 'Terjadi kesalahan saat proses penggajian: ' . $e->getMessage());
        }
    }

    /**
     * Menampilkan detail slip gaji.
     */
    public function showSlip(Gaji $gaji) // Menggunakan Route Model Binding
    {
        $gaji->load('karyawan.user'); // Load relasi
        // Jika Anda punya tabel detail_gaji, load juga relasi tersebut
        return view('admin.gaji.slip', compact('gaji'));
    }

    /**
     * Mungkin method untuk update status pembayaran, dll.
     */
}