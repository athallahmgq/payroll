<?php

namespace App\Http\Controllers\Karyawan;
// ... (use statements)
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Absensi;
use Carbon\Carbon;


class AbsensiController extends Controller
{
    private function getKaryawanOrFail()
    {
        $user = Auth::user();
        if ($user->role !== 'karyawan' || !$user->karyawan) {
            Auth::logout();
            abort(403, 'Akses tidak sah atau profil karyawan tidak lengkap.');
        }
        return $user->karyawan;
    }

    public function clockIn(Request $request)
    {
        $karyawan = $this->getKaryawanOrFail();
        $todayAbsensi = Absensi::where('karyawan_id', $karyawan->id)
                            ->whereDate('tanggal', today())->first();

        if ($todayAbsensi && $todayAbsensi->jam_masuk) {
            return back()->with('warning', 'Anda sudah melakukan presensi masuk hari ini.');
        }
        Absensi::updateOrCreate(
            ['karyawan_id' => $karyawan->id, 'tanggal' => today()],
            ['jam_masuk' => now(), 'status' => 'hadir']
        );
        return back()->with('success', 'Presensi masuk berhasil.');
    }

    public function clockOut(Request $request)
    {
        $karyawan = $this->getKaryawanOrFail();
        $absensi = Absensi::where('karyawan_id', $karyawan->id)
                        ->whereDate('tanggal', today())
                        ->whereNotNull('jam_masuk')->whereNull('jam_pulang')->first();
        if (!$absensi) {
            return back()->with('error', 'Belum presensi masuk atau sudah presensi pulang.');
        }
        $absensi->update(['jam_pulang' => now()]);
        return back()->with('success', 'Presensi pulang berhasil.');
    }

    public function riwayat(Request $request)
    {
        $karyawan = $this->getKaryawanOrFail();
        $bulan = $request->input('bulan', date('m'));
        $tahun = $request->input('tahun', date('Y'));
        $riwayat = Absensi::where('karyawan_id', $karyawan->id)
                        ->whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun)
                        ->orderBy('tanggal', 'desc')->paginate(10);

        $listBulan = []; for ($m=1; $m<=12; ++$m) $listBulan[$m] = Carbon::create()->month($m)->isoFormat('MMMM');
        $listTahun = Absensi::selectRaw('YEAR(tanggal) as tahun')->where('karyawan_id', $karyawan->id)
                              ->distinct()->orderBy('tahun', 'desc')->pluck('tahun');
        if($listTahun->isEmpty()) $listTahun->push(date('Y'));

        return view('karyawan.absensi.', compact('riwayat', 'bulan', 'tahun', 'listBulan', 'listTahun'));
    }
}
