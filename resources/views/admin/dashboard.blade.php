@extends('layouts.app')

@section('header', 'Admin Dashboard')

@section('content')
    <h3>Selamat Datang, Admin {{ Auth::user()->name }}!</h3>
    <p>Ini adalah halaman dashboard admin.</p>
    <p>Total Karyawan Terdaftar: <strong>{{ $totalKaryawan }}</strong></p>
    <p>Total Karyawan Absen Hari Ini: <strong>{{ $totalAbsensiHariIni }}</strong></p>
    {{-- Tambahkan statistik atau link cepat lainnya --}}
@endsection
