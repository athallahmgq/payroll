@extends('layouts.app')

@section('header', 'Riwayat Absensi Saya')

@section('content')
<div class="space-y-6">
    <!-- Filter Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-5 border-b border-gray-100">
            <div class="flex items-center">
                <div class="w-8 h-8 rounded-lg bg-green-100 flex items-center justify-center text-green-700 mr-3">
                    <i class="fas fa-filter"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-800">Filter Riwayat Absensi</h3>
            </div>
        </div>
        
        <div class="p-5">
            <form method="GET" action="{{ route('karyawan.absensi.riwayat') }}" class="flex flex-wrap items-end gap-4">
                <div class="w-full md:w-auto">
                    <label for="bulan" class="block text-sm font-medium text-gray-700 mb-1">Bulan:</label>
                    <select name="bulan" id="bulan" class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-green-500">
                        @foreach($listBulan as $key => $namaBulan)
                            <option value="{{ $key }}" {{ $key == $bulan ? 'selected' : '' }}>{{ $namaBulan }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="w-full md:w-auto">
                    <label for="tahun" class="block text-sm font-medium text-gray-700 mb-1">Tahun:</label>
                    <select name="tahun" id="tahun" class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-green-500">
                        @foreach($listTahun as $th)
                            <option value="{{ $th }}" {{ $th == $tahun ? 'selected' : '' }}>{{ $th }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="w-full md:w-auto">
                    <button type="submit" class="w-full md:w-auto px-4 py-2.5 bg-green-700 text-white rounded-lg hover:bg-green-800 transition-colors font-medium flex items-center">
                        <i class="fas fa-search mr-2"></i> Filter
                    </button>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden p-5">
            <div class="flex items-center">
                <div class="w-12 h-12 rounded-lg bg-green-100 flex items-center justify-center text-green-700 mr-4">
                    <i class="fas fa-calendar-check text-xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Total Kehadiran</p>
                    <h4 class="text-xl font-bold text-gray-800">{{ $riwayat->where('status', 'hadir')->count() }}</h4>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden p-5">
            <div class="flex items-center">
                <div class="w-12 h-12 rounded-lg bg-blue-100 flex items-center justify-center text-blue-700 mr-4">
                    <i class="fas fa-calendar-day text-xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Total Izin</p>
                    <h4 class="text-xl font-bold text-gray-800">{{ $riwayat->where('status', 'izin')->count() }}</h4>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden p-5">
            <div class="flex items-center">
                <div class="w-12 h-12 rounded-lg bg-yellow-100 flex items-center justify-center text-yellow-700 mr-4">
                    <i class="fas fa-procedures text-xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Total Sakit</p>
                    <h4 class="text-xl font-bold text-gray-800">{{ $riwayat->where('status', 'sakit')->count() }}</h4>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden p-5">
            <div class="flex items-center">
                <div class="w-12 h-12 rounded-lg bg-red-100 flex items-center justify-center text-red-700 mr-4">
                    <i class="fas fa-calendar-times text-xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Tanpa Keterangan</p>
                    <h4 class="text-xl font-bold text-gray-800">{{ $riwayat->where('status', 'tanpa keterangan')->count() }}</h4>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Attendance History Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-5 border-b border-gray-100">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="w-8 h-8 rounded-lg bg-green-100 flex items-center justify-center text-green-700 mr-3">
                        <i class="fas fa-history"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-800">Riwayat Absensi</h3>
                </div>
                
                <div class="text-sm text-gray-500">
                    <span>{{ $listBulan[str_pad($bulan, 2, '0', STR_PAD_LEFT)] ?? 'Bulan tidak ditemukan' }}</span>
                </div>
            </div>
        </div>
        
        @if ($riwayat && $riwayat->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr class="text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <th class="px-4 py-3 bg-gray-50">Tanggal</th>
                            <th class="px-4 py-3 bg-gray-50">Jam Masuk</th>
                            <th class="px-4 py-3 bg-gray-50">Jam Pulang</th>
                            <th class="px-4 py-3 bg-gray-50">Status</th>
                            <th class="px-4 py-3 bg-gray-50">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($riwayat as $absensi)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center text-gray-700 font-medium mr-3">
                                            {{ \Carbon\Carbon::parse($absensi->tanggal)->format('d') }}
                                        </div>
                                        <span>{{ \Carbon\Carbon::parse($absensi->tanggal)->isoFormat('DD MMMM YYYY') }}</span>
                                    </div>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    @if($absensi->jam_masuk)
                                        <div class="flex items-center">
                                            <i class="fas fa-sign-in-alt text-green-600 mr-2"></i>
                                            <span>{{ \Carbon\Carbon::parse($absensi->jam_masuk)->format('H:i:s') }}</span>
                                        </div>
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    @if($absensi->jam_pulang)
                                        <div class="flex items-center">
                                            <i class="fas fa-sign-out-alt text-blue-600 mr-2"></i>
                                            <span>{{ \Carbon\Carbon::parse($absensi->jam_pulang)->format('H:i:s') }}</span>
                                        </div>
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    @if($absensi->status == 'hadir')
                                        <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">
                                            {{ ucwords($absensi->status) }}
                                        </span>
                                    @elseif($absensi->status == 'izin')
                                        <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded-full">
                                            {{ ucwords($absensi->status) }}
                                        </span>
                                    @elseif($absensi->status == 'sakit')
                                        <span class="px-2 py-1 bg-yellow-100 text-yellow-800 text-xs rounded-full">
                                            {{ ucwords($absensi->status) }}
                                        </span>
                                    @else
                                        <span class="px-2 py-1 bg-red-100 text-red-800 text-xs rounded-full">
                                            {{ ucwords($absensi->status) }}
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    {{ $absensi->keterangan ?? '-' }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="px-4 py-3 border-t border-gray-100">
                {{ $riwayat->appends(request()->query())->links() }}
            </div>
        @else
            <div class="text-center py-12">
                <div class="w-20 h-20 bg-gray-100 rounded-full mx-auto flex items-center justify-center mb-4">
                    <i class="fas fa-calendar-times text-gray-400 text-2xl"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-800 mb-2">Tidak ada riwayat absensi</h3>
                <p class="text-gray-500">Tidak ada riwayat absensi untuk periode yang dipilih.</p>
            </div>
        @endif
    </div>
    

</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
@endpush