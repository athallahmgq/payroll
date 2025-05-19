@extends('layouts.app')

@section('header', 'Detail Karyawan: ' . $karyawan->user->name)

@section('content')
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="p-6">
        <div class="flex flex-col md:flex-row md:items-start">
            <!-- Employee Avatar -->
            <div class="flex-shrink-0 mb-6 md:mb-0 md:mr-8">
                <div class="w-24 h-24 rounded-full bg-green-100 flex items-center justify-center text-green-700 text-3xl font-bold">
                    {{ substr($karyawan->user->name, 0, 1) }}
                </div>
            </div>
            
            <!-- Employee Information -->
            <div class="flex-grow">
                <div class="mb-8">
                    <div class="flex items-center mb-4">
                        <div class="w-8 h-8 rounded-lg bg-green-100 flex items-center justify-center text-green-700 mr-3">
                            <i class="fas fa-user-lock"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-800">Data User Login</h3>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-sm text-gray-500 mb-1">Nama</p>
                            <p class="font-medium">{{ $karyawan->user->name }}</p>
                        </div>
                        
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-sm text-gray-500 mb-1">Email</p>
                            <p class="font-medium">{{ $karyawan->user->email }}</p>
                        </div>
                        
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-sm text-gray-500 mb-1">Role</p>
                            <p class="font-medium">
                                <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">
                                    {{ ucwords($karyawan->user->role) }}
                                </span>
                            </p>
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
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-sm text-gray-500 mb-1">NIK</p>
                            <p class="font-medium">{{ $karyawan->nik }}</p>
                        </div>
                        
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-sm text-gray-500 mb-1">Posisi</p>
                            <p class="font-medium">
                                <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">
                                    {{ $karyawan->posisi }}
                                </span>
                            </p>
                        </div>
                        
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-sm text-gray-500 mb-1">Tanggal Masuk</p>
                            <p class="font-medium">{{ \Carbon\Carbon::parse($karyawan->tanggal_masuk)->isoFormat('DD MMMM YYYY') }}</p>
                        </div>
                        
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-sm text-gray-500 mb-1">Gaji Pokok</p>
                            <p class="font-medium text-green-700">Rp {{ number_format($karyawan->gaji_pokok, 0, ',', '.') }}</p>
                        </div>
                        
                        <div class="bg-gray-50 p-4 rounded-lg md:col-span-2">
                            <p class="text-sm text-gray-500 mb-1">Alamat</p>
                            <p class="font-medium">{{ $karyawan->alamat ?? '-' }}</p>
                        </div>
                        
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-sm text-gray-500 mb-1">No. Telepon</p>
                            <p class="font-medium">{{ $karyawan->no_telepon ?? '-' }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="flex justify-end space-x-3 mt-8">
                    <a href="{{ route('admin.karyawan.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors font-medium">
                        <i class="fas fa-arrow-left mr-2"></i> Kembali ke Daftar
                    </a>
                    <a href="{{ route('admin.karyawan.edit', $karyawan->id) }}" class="px-4 py-2 bg-green-700 hover:text-green-800 text-white rounded-lg hover:bg-green-100 transition-colors font-medium">
                        <i class="fas fa-edit mr-2"></i> Edit
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
@endpush