@extends('layouts.app')

@section('header', 'Lengkapi Profil Karyawan')

@section('content')
    <form method="POST" action="{{ route('karyawan.profile.complete.save') }}">
        @csrf
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
        <button type="submit" class="button">Simpan Profil Karyawan</button>
    </form>
@endsection