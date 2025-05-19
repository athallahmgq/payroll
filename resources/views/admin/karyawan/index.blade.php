@extends('layouts.app')

@section('header', 'Kelola Data Karyawan')

@section('content')
<div class="space-y-6">
    <!-- Header with action button -->
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-800">Data Karyawan</h1>
        <a href="{{ route('admin.karyawan.create') }}" class="inline-flex items-center px-4 py-2 bg-green-700 text-white rounded-lg hover:bg-green-800 transition-colors text-sm font-medium">
            <i class="fas fa-user-plus mr-2"></i> Tambah Karyawan Baru
        </a>
    </div>

    <!-- Employee data card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        @if ($karyawans && $karyawans->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <th class="px-4 py-3 bg-gray-50">ID</th>
                            <th class="px-4 py-3 bg-gray-50">Nama</th>
                            <th class="px-4 py-3 bg-gray-50">Email</th>
                            <th class="px-4 py-3 bg-gray-50">NIK</th>
                            <th class="px-4 py-3 bg-gray-50">Posisi</th>
                            <th class="px-4 py-3 bg-gray-50 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($karyawans as $k_data)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-sm">{{ $k_data->id }}</td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center text-green-700 font-bold mr-3">
                                            {{ substr($k_data->user->name, 0, 1) }}
                                        </div>
                                        <span class="font-medium text-gray-800">{{ $k_data->user->name }}</span>
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-gray-600">{{ $k_data->user->email }}</td>
                                <td class="px-4 py-3 text-gray-600">{{ $k_data->nik }}</td>
                                <td class="px-4 py-3">
                                    <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">
                                        {{ $k_data->posisi }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-right">
                                    <div class="flex items-center justify-end space-x-2">
                                        <a href="{{ route('admin.karyawan.show', $k_data->id) }}" class="px-3 py-1.5 bg-blue-500 text-white text-xs rounded-lg hover:bg-blue-600 transition-colors inline-flex items-center">
                                            <i class="fas fa-eye mr-1"></i> Lihat
                                        </a>
                                        <a href="{{ route('admin.karyawan.edit', $k_data->id) }}" class="px-3 py-1.5 bg-yellow-500 text-white text-xs rounded-lg hover:bg-yellow-600 transition-colors inline-flex items-center">
                                            <i class="fas fa-edit mr-1"></i> Edit
                                        </a>
                                        <form action="{{ route('admin.karyawan.destroy', $k_data->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus karyawan {{ $k_data->user->name }}? Ini juga akan menghapus data user terkait.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-3 py-1.5 bg-red-500 text-white text-xs rounded-lg hover:bg-red-600 transition-colors inline-flex items-center">
                                                <i class="fas fa-trash-alt mr-1"></i> Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="px-4 py-3 border-t border-gray-100">
                {{ $karyawans->links() }}
            </div>
        @else
            <div class="text-center py-12">
                <div class="w-20 h-20 bg-gray-100 rounded-full mx-auto flex items-center justify-center mb-4">
                    <i class="fas fa-users text-gray-400 text-2xl"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-800 mb-2">Belum ada data karyawan</h3>
                <p class="text-gray-500 mb-6">Mulai dengan menambahkan karyawan baru ke sistem</p>
                <a href="{{ route('admin.karyawan.create') }}" class="inline-flex items-center px-4 py-2 bg-green-700 text-white rounded-lg hover:bg-green-800 transition-colors text-sm font-medium">
                    <i class="fas fa-user-plus mr-2"></i> Tambah Karyawan Baru
                </a>
            </div>
        @endif
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
@endpush