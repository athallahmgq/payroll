@extends('layouts.app')

@section('header', 'Tambah Karyawan Baru')

@section('content')
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="p-6">
        <form method="POST" action="{{ route('admin.karyawan.store') }}">
            @csrf
            
            <div class="mb-8">
                <div class="flex items-center mb-4">
                    <div class="w-8 h-8 rounded-lg bg-green-100 flex items-center justify-center text-green-700 mr-3">
                        <i class="fas fa-user-lock"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-800">Data User Login</h3>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="form-group">
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap (User)</label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" required 
                            class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-green-500">
                        @error('name') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email (User)</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required 
                            class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-green-500">
                        @error('email') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password (User)</label>
                        <input type="password" id="password" name="password" required 
                            class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-green-500">
                        @error('password') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" required 
                            class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-green-500">
                    </div>
                </div>
            </div>
            
            <div class="border-t border-gray-100 pt-6 mb-6"></div>
            
            <div class="mb-8">
                <div class="flex items-center mb-4">
                    <div class="w-8 h-8 rounded-lg bg-green-100 flex items-center justify-center text-green-700 mr-3">
                        <i class="fas fa-id-card"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-800">Data Detail Karyawan</h3>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="form-group">
                        <label for="nik" class="block text-sm font-medium text-gray-700 mb-1">NIK</label>
                        <input type="text" id="nik" name="nik" value="{{ old('nik') }}" required 
                            class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-green-500">
                        @error('nik') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="posisi" class="block text-sm font-medium text-gray-700 mb-1">Posisi</label>
                        <input type="text" id="posisi" name="posisi" value="{{ old('posisi') }}" required 
                            class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-green-500">
                        @error('posisi') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="tanggal_masuk" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Masuk</label>
                        <input type="date" id="tanggal_masuk" name="tanggal_masuk" value="{{ old('tanggal_masuk') }}" required 
                            class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-green-500">
                        @error('tanggal_masuk') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="gaji_pokok" class="block text-sm font-medium text-gray-700 mb-1">Gaji Pokok (Rp)</label>
                        <input type="number" id="gaji_pokok" name="gaji_pokok" value="{{ old('gaji_pokok') }}" required step="1000" 
                            class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-green-500">
                        @error('gaji_pokok') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                    </div>
                    
                    <div class="form-group md:col-span-2">
                        <label for="alamat" class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
                        <textarea id="alamat" name="alamat" rows="3" 
                            class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-green-500">{{ old('alamat') }}</textarea>
                        @error('alamat') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="no_telepon" class="block text-sm font-medium text-gray-700 mb-1">No. Telepon</label>
                        <input type="text" id="no_telepon" name="no_telepon" value="{{ old('no_telepon') }}" 
                            class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-green-500">
                        @error('no_telepon') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>
            
            <div class="flex justify-end space-x-3 mt-8">
                <a href="{{ route('admin.karyawan.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors font-medium">
                    Batal
                </a>
                <button type="submit" class="px-4 py-2 bg-green-700 text-white rounded-lg hover:bg-green-800 transition-colors font-medium">
                    <i class="fas fa-save mr-2"></i> Simpan Karyawan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
@endpush