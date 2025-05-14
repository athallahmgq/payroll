@extends('layouts.app') 

@section('content')
    <h1>Selamat Datang di Aplikasi Payroll Sederhana</h1>
    <p>Silakan login atau register untuk melanjutkan.</p>
    @guest
    <p>
        <a href="{{ route('login') }}" class="button">Login</a>
        <a href="{{ route('register') }}" class="button button-green">Register</a>
    </p>
    @endguest
@endsection