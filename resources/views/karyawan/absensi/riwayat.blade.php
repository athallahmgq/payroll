@extends('layouts.app')

@section('header', 'Riwayat Absensi Saya')

@section('content')
    <form method="GET" action="{{ route('karyawan.absensi.riwayat') }}" style="margin-bottom: 20px;">
        <label for="bulan">Bulan:</label>
        <select name="bulan" id="bulan">
            @foreach($listBulan as $key => $namaBulan)
                <option value="{{ $key }}" {{ $key == $bulan ? 'selected' : '' }}>{{ $namaBulan }}</option>
            @endforeach
        </select>

        <label for="tahun" style="margin-left: 10px;">Tahun:</label>
        <select name="tahun" id="tahun">
            @foreach($listTahun as $th)
                <option value="{{ $th }}" {{ $th == $tahun ? 'selected' : '' }}>{{ $th }}</option>
            @endforeach
        </select>
        <button type="submit" style="margin-left: 10px;">Filter</button>
    </form>

    @if ($riwayat && $riwayat->count() > 0)
        <table>
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Jam Masuk</th>
                    <th>Jam Pulang</th>
                    <th>Status</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($riwayat as $absensi)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($absensi->tanggal)->isoFormat('DD MMMM YYYY') }}</td>
                        <td>{{ $absensi->jam_masuk ? \Carbon\Carbon::parse($absensi->jam_masuk)->format('H:i:s') : '-' }}</td>
                        <td>{{ $absensi->jam_pulang ? \Carbon\Carbon::parse($absensi->jam_pulang)->format('H:i:s') : '-' }}</td>
                        <td>{{ ucwords($absensi->status) }}</td>
                        <td>{{ $absensi->keterangan ?? '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="pagination">
            {{ $riwayat->appends(request()->query())->links() }}
        </div>
    @else
        <p>Tidak ada riwayat absensi untuk periode yang dipilih.</p>
    @endif
@endsection