@extends('layouts.app')

@section('header', 'Rekap Absensi Semua Karyawan')

@section('content')
    <form method="GET" action="{{ route('admin.absensi.index') }}" style="margin-bottom: 20px;">
        <label for="karyawan_id_filter">Karyawan:</label>
        <select name="karyawan_id" id="karyawan_id_filter">
            <option value="">Semua Karyawan</option>
            @foreach ($karyawans as $k_data)
                <option value="{{ $k_data->id }}" {{ request('karyawan_id') == $k_data->id ? 'selected' : '' }}>
                    {{ $k_data->user->name }} ({{ $k_data->nik }})
                </option>
            @endforeach
        </select>

        <label for="bulan_filter" style="margin-left: 10px;">Bulan:</label>
        <select name="bulan" id="bulan_filter">
            @foreach($listBulan as $key => $namaBulan)
                <option value="{{ $key }}" {{ $key == $selectedBulan ? 'selected' : '' }}>{{ $namaBulan }}</option>
            @endforeach
        </select>

        <label for="tahun_filter" style="margin-left: 10px;">Tahun:</label>
        <select name="tahun" id="tahun_filter">
            @foreach($listTahun as $th)
                <option value="{{ $th }}" {{ $th == $selectedTahun ? 'selected' : '' }}>{{ $th }}</option>
            @endforeach
        </select>
        <button type="submit" style="margin-left: 10px;">Filter</button>
    </form>

    @if ($absensi && $absensi->count() > 0)
        <table>
            <thead>
                <tr>
                    <th>Karyawan</th>
                    <th>Tanggal</th>
                    <th>Jam Masuk</th>
                    <th>Jam Pulang</th>
                    <th>Status</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($absensi as $item)
                    <tr>
                        <td> {{ $item->karyawan && $item->karyawan->user ? $item->karyawan->user->name : '-' }} 
                            ({{ $item->karyawan->nik ?? '-' }})
                        </td>
                        <td>{{ \Carbon\Carbon::parse($item->tanggal)->isoFormat('DD MMM YYYY') }}</td>
                        <td>{{ $item->jam_masuk ? \Carbon\Carbon::parse($item->jam_masuk)->format('H:i') : '-' }}</td>
                        <td>{{ $item->jam_pulang ? \Carbon\Carbon::parse($item->jam_pulang)->format('H:i') : '-' }}</td>
                        <td>{{ ucwords($item->status) }}</td>
                        <td>{{ $item->keterangan ?? '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @if ($absensi->hasPages())
        <div class="mt-3">
            {{ $absensi->appends(request()->query())->links() }}
        </div>
        @endif
    @else
        <p>Tidak ada data absensi untuk filter yang dipilih.</p>
    @endif
@endsection