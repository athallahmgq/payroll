@extends('layouts.app')

@section('header', 'Edit Karyawan: ' . $karyawan->user->name)

@section('content')
    <form method="POST" action="{{ route('admin.karyawan.update', $karyawan->id) }}">
        @csrf
        @method('PUT')
        <h3>Data User Login</h3>
        <div class="form-group">
            <label for="name">Nama Lengkap (User)</label>
            <input type="text" id="name" name="name" value="{{ old('name', $karyawan->user->name) }}" required>
            @error('name') <span class="error-message">{{ $message }}</span> @enderror
        </div>
        <div class="form-group">
            <label for="email">Email (User)</label>
            <input type="email" id="email" name="email" value="{{ old('email', $karyawan->user->email) }}" required>
            @error('email') <span class="error-message">{{ $message }}</span> @enderror
        </div>
        <div class="form-group">
            <label for="password">Password Baru (User) - Kosongkan jika tidak diubah</label>
            <input type="password" id="password" name="password">
            @error('password') <span class="error-message">{{ $message }}</span> @enderror
        </div>
        <div class="form-group">
            <label for="password_confirmation">Konfirmasi Password Baru</label>
            <input type="password" id="password_confirmation" name="password_confirmation">
        </div>

        <hr style="margin: 20px 0;">
        <h3>Data Detail Karyawan</h3>
        <div class="form-group">
            <label for="nik">NIK</label>
            <input type="text" id="nik" name="nik" value="{{ old('nik', $karyawan->nik) }}" required>
            @error('nik') <span class="error-message">{{ $message }}</span> @enderror
        </div>
        <div class="form-group">
            <label for="posisi">Posisi</label>
            <input type="text" id="posisi" name="posisi" value="{{ old('posisi', $karyawan->posisi) }}" required>
            @error('posisi') <span class="error-message">{{ $message }}</span> @enderror
        </div>
        <div class="form-group">
            <label for="tanggal_masuk">Tanggal Masuk</label>
            <input type="date" id="tanggal_masuk" name="tanggal_masuk" value="{{ old('tanggal_masuk', $karyawan->tanggal_masuk) }}" required>
            @error('tanggal_masuk') <span class="error-message">{{ $message }}</span> @enderror
        </div>
        <div class="form-group">
            <label for="gaji_pokok">Gaji Pokok (Rp)</label>
            <input type="number" id="gaji_pokok" name="gaji_pokok" value="{{ old('gaji_pokok', $karyawan->gaji_pokok) }}" required step="1000">
            @error('gaji_pokok') <span class="error-message">{{ $message }}</span> @enderror
        </div>
        <div class="form-group">
            <label for="alamat">Alamat</label>
            <textarea id="alamat" name="alamat" rows="3">{{ old('alamat', $karyawan->alamat) }}</textarea>
            @error('alamat') <span class="error-message">{{ $message }}</span> @enderror
        </div>
        <div class="form-group">
            <label for="no_telepon">No. Telepon</label>
            <input type="text" id="no_telepon" name="no_telepon" value="{{ old('no_telepon', $karyawan->no_telepon) }}">
            @error('no_telepon') <span class="error-message">{{ $message }}</span> @enderror
        </div>

        <button type="submit" class="button">Update Karyawan</button>
        <a href="{{ route('admin.karyawan.index') }}" class="button" style="background-color: #6c757d;">Batal</a>
    </form>
@endsection