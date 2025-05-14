@extends('layouts.app')

@section('header', 'Dashboard Karyawan')

@section('content')
    <h3>Selamat Datang, {{ Auth::user()->name }}!</h3>

    @if ($karyawan)
        <p>NIK: {{ $karyawan->nik }} | Posisi: {{ $karyawan->posisi }}</p>

        <h4>Presensi Hari Ini ({{ \Carbon\Carbon::now()->isoFormat('dddd, D MMMM YYYY') }})</h4>
        @if (!$absensiHariIni || !$absensiHariIni->jam_masuk)
            <form method="POST" action="{{ route('karyawan.absensi.clockin') }}" style="display:inline-block;">
                @csrf
                <button type="submit" class="button button-green">Presensi Masuk</button>
            </form>
        @else
            <p>Presensi Masuk: {{ \Carbon\Carbon::parse($absensiHariIni->jam_masuk)->format('H:i:s') }}</p>
            @if (!$absensiHariIni->jam_pulang)
                <form method="POST" action="{{ route('karyawan.absensi.clockout') }}" style="display:inline-block;">
                    @csrf
                    <button type="submit" class="button">Presensi Pulang</button>
                </form>
            @else
                <p>Presensi Pulang: {{ \Carbon\Carbon::parse($absensiHariIni->jam_pulang)->format('H:i:s') }}</p>
            @endif
        @endif
        @if ($absensiHariIni && $absensiHariIni->status !== 'hadir')
            <p>Status hari ini: <strong>{{ ucwords($absensiHariIni->status) }}</strong></p>
        @endif


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
            <p><a href="{{ route('karyawan.absensi.riwayat') }}">Lihat Semua Riwayat</a></p>
        @else
            <p>Belum ada riwayat absensi.</p>
        @endif
    @else
        <p class="alert alert-info">
            Data profil karyawan Anda (NIK, Posisi, dll.) belum lengkap.
            Silakan lengkapi data Anda untuk mengakses fitur absensi.
        </p>
        <a href="{{ route('karyawan.profile.complete.form') }}" class="button">Lengkapi Profil Karyawan</a>
    @endif
@endsection