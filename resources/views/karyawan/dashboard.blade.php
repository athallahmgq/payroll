@extends('layouts.app')

@section('header', 'Dashboard Karyawan')

@section('content')
    <h3>Selamat Datang, {{ Auth::user()->name }}!</h3>

    @if ($karyawan)
        <div class="dashboard-card">
            <h4>Informasi Karyawan</h4>
            <table class="info-table">
                <tr>
                    <td><strong>NIK:</strong></td>
                    <td>{{ $karyawan->nik }}</td>
                    <td><strong>Posisi:</strong></td>
                    <td>{{ $karyawan->posisi }}</td>
                </tr>
                <tr>
                    <td><strong>Tanggal Masuk:</strong></td>
                    <td>{{ \Carbon\Carbon::parse($karyawan->tanggal_masuk)->isoFormat('DD MMMM YYYY') }}</td>
                    <td><strong>Gaji Pokok:</strong></td>
                    <td>Rp {{ number_format($karyawan->gaji_pokok, 0, ',', '.') }}</td>
                </tr>
            </table>
        </div>

        <div class="dashboard-card">
            <h4>Presensi Hari Ini ({{ \Carbon\Carbon::now()->isoFormat('dddd, D MMMM YYYY') }})</h4>
            <div class="status-container">
                @if (!$absensiHariIni || !$absensiHariIni->jam_masuk)
                    <div class="clock-status no-checkin">
                        <div class="status-label">Presensi Masuk</div>
                        <div class="status-value">Belum Absen</div>
                        <form method="POST" action="{{ route('karyawan.absensi.clockin') }}">
                            @csrf
                            <button type="submit" class="button button-green">Presensi Masuk</button>
                        </form>
                    </div>
                @else
                    <div class="clock-status checkin-complete">
                        <div class="status-label">Presensi Masuk</div>
                        <div class="status-value">{{ \Carbon\Carbon::parse($absensiHariIni->jam_masuk)->format('H:i:s') }}</div>
                        <div class="status-icon">✓</div>
                    </div>
                @endif

                @if ($absensiHariIni && $absensiHariIni->jam_masuk && !$absensiHariIni->jam_pulang)
                    <div class="clock-status no-checkout">
                        <div class="status-label">Presensi Pulang</div>
                        <div class="status-value">Belum Absen</div>
                        <form method="POST" action="{{ route('karyawan.absensi.clockout') }}">
                            @csrf
                            <button type="submit" class="button">Presensi Pulang</button>
                        </form>
                    </div>
                @elseif ($absensiHariIni && $absensiHariIni->jam_pulang)
                    <div class="clock-status checkout-complete">
                        <div class="status-label">Presensi Pulang</div>
                        <div class="status-value">{{ \Carbon\Carbon::parse($absensiHariIni->jam_pulang)->format('H:i:s') }}</div>
                        <div class="status-icon">✓</div>
                    </div>
                @elseif (!$absensiHariIni || !$absensiHariIni->jam_masuk)
                    <div class="clock-status not-available">
                        <div class="status-label">Presensi Pulang</div>
                        <div class="status-value">Belum bisa absen pulang</div>
                    </div>
                @endif
            </div>

            @if ($absensiHariIni && $absensiHariIni->status !== 'hadir')
                <div class="status-special">
                    <p>Status hari ini: <strong>{{ ucwords($absensiHariIni->status) }}</strong></p>
                    @if ($absensiHariIni->keterangan)
                        <p>Keterangan: {{ $absensiHariIni->keterangan }}</p>
                    @endif
                </div>
            @endif
        </div>

        <div class="dashboard-card">
            <h4>Riwayat Absensi Terakhir</h4>
            @if ($riwayatTerakhir && $riwayatTerakhir->count() > 0)
                <table>
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Jam Masuk</th>
                            <th>Jam Pulang</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($riwayatTerakhir as $absensi)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($absensi->tanggal)->isoFormat('D MMM YYYY') }}</td>
                                <td>{{ $absensi->jam_masuk ? \Carbon\Carbon::parse($absensi->jam_masuk)->format('H:i') : '-' }}</td>
                                <td>{{ $absensi->jam_pulang ? \Carbon\Carbon::parse($absensi->jam_pulang)->format('H:i') : '-' }}</td>
                                <td>{{ ucwords($absensi->status) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="action-links">
                    <a href="{{ route('karyawan.absensi.riwayat') }}" class="button">Lihat Semua Riwayat</a>
                </div>
            @else
                <p>Belum ada riwayat absensi.</p>
            @endif
        </div>

        <!-- Riwayat Gaji (jika sudah tersedia untuk karyawan) -->
        <div class="dashboard-card">
            <h4>Riwayat Gaji Terakhir</h4>
            @if (isset($riwayatGaji) && $riwayatGaji->count() > 0)
                <table>
                    <thead>
                        <tr>
                            <th>Periode</th>
                            <th>Gaji Pokok</th>
                            <th>Potongan</th>
                            <th>Gaji Bersih</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($riwayatGaji as $gaji)
                            <tr>
                                <td>{{ $bulanList[$gaji->bulan] ?? $gaji->bulan }} {{ $gaji->tahun }}</td>
                                <td>Rp {{ number_format($gaji->gaji_pokok, 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($gaji->potongan, 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($gaji->gaji_bersih, 0, ',', '.') }}</td>
                                <td>
                                    @if(isset($gaji->id))
                                        <a href="{{ route('karyawan.gaji.slip', $gaji->id) }}" class="button" target="_blank">
                                            <i class="fa fa-print"></i> Lihat Slip Gaji
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p>Belum ada riwayat gaji.</p>
            @endif
        </div>

    @else
        <div class="dashboard-card alert-card">
            <div class="alert alert-info">
                <h4>Data Profil Belum Lengkap</h4>
                <p>Data profil karyawan Anda (NIK, Posisi, dll.) belum lengkap.
                Silakan lengkapi data Anda untuk mengakses fitur absensi.</p>
                <a href="{{ route('karyawan.profile.complete.form') }}" class="button">Lengkapi Profil Karyawan</a>
            </div>
        </div>
    @endif
@endsection

@push('styles')
<style>
    .dashboard-card {
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        padding: 20px;
        margin-bottom: 20px;
    }
    .status-container {
        display: flex;
        justify-content: space-around;
        flex-wrap: wrap;
        gap: 20px;
        margin-bottom: 15px;
    }
    .clock-status {
        min-width: 200px;
        padding: 15px;
        border-radius: 8px;
        text-align: center;
    }
    .no-checkin, .no-checkout {
        background-color: #fff3cd;
        border: 1px solid #ffeeba;
    }
    .checkin-complete, .checkout-complete {
        background-color: #d4edda;
        border: 1px solid #c3e6cb;
    }
    .not-available {
        background-color: #e9ecef;
        border: 1px solid #dee2e6;
        color: #6c757d;
    }
    .status-special {
        background-color: #d1ecf1;
        border: 1px solid #bee5eb;
        padding: 10px;
        border-radius: 8px;
        margin-top: 10px;
    }
    .status-label {
        font-weight: bold;
        margin-bottom: 5px;
    }
    .status-value {
        font-size: 1.2em;
        margin-bottom: 10px;
    }
    .status-icon {
        font-size: 1.5em;
        color: #28a745;
    }
    .action-links {
        margin-top: 15px;
        text-align: right;
    }
    .info-table {
        width: 100%;
        border-collapse: collapse;
    }
    .info-table td {
        padding: 8px;
        border: none;
    }
    .alert-card {
        border-left: 4px solid #17a2b8;
    }
</style>
@endpush
