@extends('layouts.guest')

@section('content')
    <h2>Register</h2>

    <form method="POST" action="{{ route('register') }}">
        @csrf
        <div class="form-group">
            <label for="name">Nama</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus>
            @error('name') <span class="error-message">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required>
            @error('email') <span class="error-message">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input id="password" type="password" name="password" required>
            @error('password') <span class="error-message">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label for="password_confirmation">Konfirmasi Password</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required>
        </div>
        

        <div class="form-group">
            <button type="submit">Register</button>
        </div>
        <div class="text-center mt-2">
            <a href="{{ route('login') }}">Sudah punya akun? Login</a>
        </div>
    </form>
@endsection