@extends('layouts.guest')

@section('content')
    <h2>Login</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            Email atau password salah.
        </div>
    @endif
     @if (session('error')) {{-- Dari AdminMiddleware --}}
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif


    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="form-group">
            <label for="email">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input id="password" type="password" name="password" required>
        </div>

        <div class="form-group">
            <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
            <label for="remember" style="display: inline;">Ingat Saya</label>
        </div>

        <div class="form-group">
            <button type="submit">Login</button>
        </div>
        <div class="text-center mt-2">
            <a href="{{ route('register') }}">Belum punya akun? Register</a>
        </div>
    </form>
@endsection