@extends('layouts.app')

@section('header', 'Rekap Absensi Semua Karyawan')

@section('content')
<div class="space-y-6">
    <!-- Filter Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-5 border-b border-gray-100">
            <div class="flex items-center">
                <div class="w-8 h-8 rounded-lg bg-green-100 flex items-center justify-center text-green-700 mr-3">
                    <i class="fas fa-filter"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-800">Filter Data Absensi</h3>
            </div>
        </div>
        
        <div class="p-5">
            <form method="GET" action="{{ route('admin.absensi.index') }}" class="space-y-4 md:space-y-0 md:flex md:flex-wrap md:items-end md:gap-4">
                <div class="w-full md:w-auto md:flex-1">
                    <label for="karyawan_id_filter" class="block text-sm font-medium text-gray-700 mb-1">Karyawan:</label>
                    <select name="karyawan_id" id="karyawan_id_filter" class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-green-500">
                        <option value="">Semua Karyawan</option>
                        @foreach ($karyawans as $k_data)
                            <option value="{{ $k_data->id }}" {{ request('karyawan_id') == $k_data->id ? 'selected' : '' }}>
                                {{ $k_data->user->name }} ({{ $k_data->nik }})
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="w-full md:w-auto">
                    <label for="bulan_filter" class="block text-sm font-medium text-gray-700 mb-1">Bulan:</label>
                    <select name="bulan" id="bulan_filter" class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-green-500">
                        @foreach($listBulan as $key => $namaBulan)
                            <option value="{{ $key }}" {{ $key == $selectedBulan ? 'selected' : '' }}>{{ $namaBulan }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="w-full md:w-auto">
                    <label for="tahun_filter" class="block text-sm font-medium text-gray-700 mb-1">Tahun:</label>
                    <select name="tahun" id="tahun_filter" class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-green-500">
                        @foreach($listTahun as $th)
                            <option value="{{ $th }}" {{ $th == $selectedTahun ? 'selected' : '' }}>{{ $th }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="w-full md:w-auto">
                    <button type="submit" class="w-full md:w-auto px-4 py-2.5 bg-green-700 text-white rounded-lg hover:bg-green-800 transition-colors font-medium flex items-center justify-center">
                        <i class="fas fa-search mr-2"></i> Filter
                    </button>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Attendance Data Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-5 border-b border-gray-100">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="w-8 h-8 rounded-lg bg-green-100 flex items-center justify-center text-green-700 mr-3">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-800">Data Absensi</h3>
                </div>
                
                <div class="flex items-center text-sm text-gray-500">
                    <i class="fas fa-calendar-alt mr-2"></i>
                    <span>{{ $listBulan[$selectedBulan] }} {{ $selectedTahun }}</span>
                </div>
            </div>
        </div>
        
        @if ($absensi && $absensi->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <th class="px-4 py-3 bg-gray-50">Karyawan</th>
                            <th class="px-4 py-3 bg-gray-50">Tanggal</th>
                            <th class="px-4 py-3 bg-gray-50">Jam Masuk</th>
                            <th class="px-4 py-3 bg-gray-50">Jam Pulang</th>
                            <th class="px-4 py-3 bg-gray-50">Status</th>
                            <th class="px-4 py-3 bg-gray-50">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($absensi as $item)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center text-green-700 font-bold mr-3">
                                            {{ substr($item->karyawan && $item->karyawan->user ? $item->karyawan->user->name : '-', 0, 1) }}
                                        </div>
                                        <div>
                                            <div class="font-medium text-gray-800">
                                                {{ $item->karyawan && $item->karyawan->user ? $item->karyawan->user->name : '-' }}
                                            </div>
                                            <div class="text-xs text-gray-500">{{ $item->karyawan->nik ?? '-' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-gray-600">{{ \Carbon\Carbon::parse($item->tanggal)->isoFormat('DD MMM YYYY') }}</td>
                                <td class="px-4 py-3 text-gray-600">{{ $item->jam_masuk ? \Carbon\Carbon::parse($item->jam_masuk)->format('H:i') : '-' }}</td>
                                <td class="px-4 py-3 text-gray-600">{{ $item->jam_pulang ? \Carbon\Carbon::parse($item->jam_pulang)->format('H:i') : '-' }}</td>
                                <td class="px-4 py-3">
                                    @if($item->status == 'tepat waktu')
                                        <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">
                                            {{ ucwords($item->status) }}
                                        </span>
                                    @elseif($item->status == 'terlambat')
                                        <span class="px-2 py-1 bg-yellow-100 text-yellow-800 text-xs rounded-full">
                                            {{ ucwords($item->status) }}
                                        </span>
                                    @elseif($item->status == 'tidak hadir')
                                        <span class="px-2 py-1 bg-red-100 text-red-800 text-xs rounded-full">
                                            {{ ucwords($item->status) }}
                                        </span>
                                    @else
                                        <span class="px-2 py-1 bg-gray-100 text-gray-800 text-xs rounded-full">
                                            {{ ucwords($item->status) }}
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-gray-600">{{ $item->keterangan ?? '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            @if ($absensi->hasPages())
                <div class="px-4 py-3 border-t border-gray-100">
                    {{ $absensi->appends(request()->query())->links() }}
                </div>
            @endif
        @else
            <div class="text-center py-12">
                <div class="w-20 h-20 bg-gray-100 rounded-full mx-auto flex items-center justify-center mb-4">
                    <i class="fas fa-calendar-times text-gray-400 text-2xl"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-800 mb-2">Tidak ada data absensi</h3>
                <p class="text-gray-500">Tidak ada data absensi untuk filter yang dipilih.</p>
            </div>
        @endif
    </div>
    
    
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
@endpush