@extends('layouts.app')

@section('header', 'Detail Karyawan: ' . $karyawan->user->name)

@section('content')
    <h3>Data User Login</h3>
    <p><strong>Nama:</strong> {{ $karyawan->user->name }}</p>
    <p><strong>Email:</strong> {{ $karyawan->user->email }}</p>
    <p><strong>Role:</strong> {{ ucwords($karyawan->user->role) }}</p>

    <hr style="margin: 20px 0;">
    <h3>Data Detail Karyawan</h3>
    <p><strong>NIK:</strong> {{ $karyawan->nik }}</p>
    <p><strong>Posisi:</strong> {{ $karyawan->posisi }}</p>
    <p><strong>Tanggal Masuk:</strong> {{ \Carbon\Carbon::parse($karyawan->tanggal_masuk)->isoFormat('DD MMMM YYYY') }}</p>
    <p><strong>Gaji Pokok:</strong> Rp {{ number_format($karyawan->gaji_pokok, 0, ',', '.') }}</p>
    <p><strong>Alamat:</strong> {{ $karyawan->alamat ?? '-' }}</p>
    <p><strong>No. Telepon:</strong> {{ $karyawan->no_telepon ?? '-' }}</p>

    <div style="margin-top: 20px;">
        <a href="{{ route('admin.karyawan.edit', $karyawan->id) }}" class="button" style="background-color: #ffed4a; color: #333; margin-right:5px;">Edit</a>
        <a href="{{ route('admin.karyawan.index') }}" class="button" style="background-color: #6c757d;">Kembali ke Daftar</a>
    </div>
@endsection
