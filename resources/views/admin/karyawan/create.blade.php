@extends('layouts.app')

@section('header', 'Tambah Karyawan Baru')

@section('content')
    <form method="POST" action="{{ route('admin.karyawan.store') }}">
        @csrf
        <h3>Data User Login</h3>
        <div class="form-group">
            <label for="name">Nama Lengkap (User)</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}" required>
            @error('name') <span class="error-message">{{ $message }}</span> @enderror
        </div>
        <div class="form-group">
            <label for="email">Email (User)</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" required>
            @error('email') <span class="error-message">{{ $message }}</span> @enderror
        </div>
        <div class="form-group">
            <label for="password">Password (User)</label>
            <input type="password" id="password" name="password" required>
            @error('password') <span class="error-message">{{ $message }}</span> @enderror
        </div>
        <div class="form-group">
            <label for="password_confirmation">Konfirmasi Password</label>
            <input type="password" id="password_confirmation" name="password_confirmation" required>
        </div>
        {{-- Role otomatis 'karyawan' dari controller --}}

        <hr style="margin: 20px 0;">
        <h3>Data Detail Karyawan</h3>
        <div class="form-group">
            <label for="nik">NIK</label>
            <input type="text" id="nik" name="nik" value="{{ old('nik') }}" required>
            @error('nik') <span class="error-message">{{ $message }}</span> @enderror
        </div>
        <div class="form-group">
            <label for="posisi">Posisi</label>
            <input type="text" id="posisi" name="posisi" value="{{ old('posisi') }}" required>
            @error('posisi') <span class="error-message">{{ $message }}</span> @enderror
        </div>
        <div class="form-group">
            <label for="tanggal_masuk">Tanggal Masuk</label>
            <input type="date" id="tanggal_masuk" name="tanggal_masuk" value="{{ old('tanggal_masuk') }}" required>
            @error('tanggal_masuk') <span class="error-message">{{ $message }}</span> @enderror
        </div>
        <div class="form-group">
            <label for="gaji_pokok">Gaji Pokok (Rp)</label>
            <input type="number" id="gaji_pokok" name="gaji_pokok" value="{{ old('gaji_pokok') }}" required step="1000">
            @error('gaji_pokok') <span class="error-message">{{ $message }}</span> @enderror
        </div>
        <div class="form-group">
            <label for="alamat">Alamat</label>
            <textarea id="alamat" name="alamat" rows="3">{{ old('alamat') }}</textarea>
            @error('alamat') <span class="error-message">{{ $message }}</span> @enderror
        </div>
        <div class="form-group">
            <label for="no_telepon">No. Telepon</label>
            <input type="text" id="no_telepon" name="no_telepon" value="{{ old('no_telepon') }}">
            @error('no_telepon') <span class="error-message">{{ $message }}</span> @enderror
        </div>

        <button type="submit" class="button">Simpan Karyawan</button>
        <a href="{{ route('admin.karyawan.index') }}" class="button" style="background-color: #6c757d;">Batal</a>
    </form>
@endsection