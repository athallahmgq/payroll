@extends('layouts.app')

@section('header', 'Lengkapi Profil Karyawan')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-5 border-b border-gray-100">
            <div class="flex items-center">
                <div class="w-8 h-8 rounded-lg bg-green-100 flex items-center justify-center text-green-700 mr-3">
                    <i class="fas fa-user-edit"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-800">Lengkapi Data Profil Anda</h3>
            </div>
        </div>
        
        <div class="p-6">
            <form method="POST" action="{{ route('karyawan.profile.complete.save') }}" class="space-y-6">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- NIK Field -->
                    <div class="space-y-2">
                        <label for="nik" class="block text-sm font-medium text-gray-700">NIK</label>
                        <div class="relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-id-card text-gray-400"></i>
                            </div>
                            <input type="text" id="nik" name="nik" value="{{ old('nik') }}" required
                                class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                placeholder="Masukkan NIK">
                        </div>
                        @error('nik') 
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Posisi Field -->
                    <div class="space-y-2">
                        <label for="posisi" class="block text-sm font-medium text-gray-700">Posisi</label>
                        <div class="relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-briefcase text-gray-400"></i>
                            </div>
                            <input type="text" id="posisi" name="posisi" value="{{ old('posisi') }}" required
                                class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                placeholder="Masukkan posisi/jabatan">
                        </div>
                        @error('posisi') 
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Tanggal Masuk Field -->
                    <div class="space-y-2">
                        <label for="tanggal_masuk" class="block text-sm font-medium text-gray-700">Tanggal Masuk</label>
                        <div class="relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-calendar-alt text-gray-400"></i>
                            </div>
                            <input type="date" id="tanggal_masuk" name="tanggal_masuk" value="{{ old('tanggal_masuk') }}" required
                                class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                        </div>
                        @error('tanggal_masuk') 
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Gaji Pokok Field -->
                    <div class="space-y-2">
                        <label for="gaji_pokok" class="block text-sm font-medium text-gray-700">Gaji Pokok (Rp)</label>
                        <div class="relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-money-bill-wave text-gray-400"></i>
                            </div>
                            <input type="number" id="gaji_pokok" name="gaji_pokok" value="{{ old('gaji_pokok') }}" required step="1000"
                                class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                placeholder="Masukkan gaji pokok">
                        </div>
                        @error('gaji_pokok') 
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <!-- Alamat Field -->
                <div class="space-y-2">
                    <label for="alamat" class="block text-sm font-medium text-gray-700">Alamat</label>
                    <div class="relative rounded-md shadow-sm">
                        <div class="absolute top-3 left-3 flex items-start pointer-events-none">
                            <i class="fas fa-home text-gray-400"></i>
                        </div>
                        <textarea id="alamat" name="alamat" rows="3"
                            class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                            placeholder="Masukkan alamat lengkap">{{ old('alamat') }}</textarea>
                    </div>
                    @error('alamat') 
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- No. Telepon Field -->
                <div class="space-y-2">
                    <label for="no_telepon" class="block text-sm font-medium text-gray-700">No. Telepon</label>
                    <div class="relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-phone text-gray-400"></i>
                        </div>
                        <input type="text" id="no_telepon" name="no_telepon" value="{{ old('no_telepon') }}"
                            class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                            placeholder="Masukkan nomor telepon">
                    </div>
                    @error('no_telepon') 
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="pt-4 border-t border-gray-100">
                    <div class="flex justify-end">
                        <button type="submit" class="px-4 py-2.5 bg-green-700 text-white rounded-lg hover:bg-green-800 transition-colors font-medium flex items-center">
                            <i class="fas fa-save mr-2"></i> Simpan Profil Karyawan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
    <div class="mt-6 bg-white rounded-xl shadow-sm border-l-4 border-blue-500 p-4">
        <div class="flex">
            <div class="flex-shrink-0">
                <i class="fas fa-info-circle text-blue-500"></i>
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-medium text-blue-800">Informasi Penting</h3>
                <div class="mt-2 text-sm text-blue-700">
                    <p>Data yang Anda masukkan akan digunakan untuk keperluan administrasi perusahaan. Pastikan data yang dimasukkan sudah benar.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
@endpush