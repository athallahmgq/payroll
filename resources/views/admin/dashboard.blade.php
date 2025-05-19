@extends('layouts.app')

@section('header', 'Admin Dashboard')

@section('content')
    <div class="space-y-8">
        <!-- Welcome Message -->
        <div class="mb-6">
            <h3 class="text-xl font-semibold text-gray-800">Selamat Datang, Admin {{ Auth::user()->name }}!</h3>
        </div>

        <!-- Dashboard Summary Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 transition-all duration-200 hover:shadow-md">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Total Karyawan</p>
                        <h3 class="text-2xl font-bold text-green-700 mt-1">{{ $totalKaryawan }}</h3>
                    </div>
                    <div class="w-12 h-12 rounded-full bg-mint-100 flex items-center justify-center text-green-700">
                        <i class="fas fa-users text-xl"></i>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 transition-all duration-200 hover:shadow-md">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Absen Hari Ini</p>
                        <h3 class="text-2xl font-bold text-green-700 mt-1">{{ $totalAbsensiHariIni }}</h3>
                    </div>
                    <div class="w-12 h-12 rounded-full bg-mint-100 flex items-center justify-center text-green-700">
                        <i class="fas fa-calendar-check text-xl"></i>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 transition-all duration-200 hover:shadow-md">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Tepat Waktu</p>
                        <h3 class="text-2xl font-bold text-green-700 mt-1">{{ $totalKaryawanTepat ?? 0 }}</h3>
                    </div>
                    <div class="w-12 h-12 rounded-full bg-mint-100 flex items-center justify-center text-green-700">
                        <i class="fas fa-award text-xl"></i>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 transition-all duration-200 hover:shadow-md">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Tanpa Keterangan</p>
                        <h3 class="text-2xl font-bold text-coral-500 mt-1">{{ $totalKaryawanTanpaKeterangan ?? 0 }}</h3>
                    </div>
                    <div class="w-12 h-12 rounded-full bg-coral-100 flex items-center justify-center text-coral-500">
                        <i class="fas fa-exclamation-triangle text-xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- First Row Cards -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Karyawan Baru Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
                    <h4 class="font-semibold text-gray-800">Karyawan Terbaru</h4>
                    <a href="{{ route('admin.karyawan.index') }}" class="text-sm text-green-700 hover:underline flex items-center">
                        Lihat Semua
                        <i class="fas fa-chevron-right ml-1 text-xs"></i>
                    </a>
                </div>
                
                <div class="p-6">
                    @if (isset($karyawanTerbaru) && $karyawanTerbaru->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead>
                                    <tr class="text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        <th class="px-4 py-3 bg-gray-50">Nama</th>
                                        <th class="px-4 py-3 bg-gray-50">NIK</th>
                                        <th class="px-4 py-3 bg-gray-50">Posisi</th>
                                        <th class="px-4 py-3 bg-gray-50">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @foreach ($karyawanTerbaru as $k_data)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-4 py-3">{{ $k_data->user->name }}</td>
                                            <td class="px-4 py-3">{{ $k_data->nik }}</td>
                                            <td class="px-4 py-3">{{ $k_data->posisi }}</td>
                                            <td class="px-4 py-3">
                                                <a href="{{ route('admin.karyawan.show', $k_data->id) }}" class="px-3 py-1 bg-green-700 text-white text-xs rounded-lg hover:bg-green-800 transition-colors">
                                                    Detail
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4 flex justify-end">
                            <a href="{{ route('admin.karyawan.create') }}" class="inline-flex items-center px-4 py-2 bg-green-700 text-white rounded-lg hover:bg-green-800 transition-colors text-sm font-medium">
                                <i class="fas fa-plus mr-2"></i> Tambah Karyawan Baru
                            </a>
                        </div>
                    @else
                        <div class="text-center py-8">
                            <div class="w-16 h-16 bg-gray-100 rounded-full mx-auto flex items-center justify-center mb-4">
                                <i class="fas fa-users text-gray-400 text-xl"></i>
                            </div>
                            <p class="text-gray-500 mb-4">Belum ada data karyawan.</p>
                            <a href="{{ route('admin.karyawan.create') }}" class="inline-flex items-center px-4 py-2 bg-green-700 text-white rounded-lg hover:bg-green-800 transition-colors text-sm font-medium">
                                <i class="fas fa-plus mr-2"></i> Tambah Karyawan Baru
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Absensi Hari Ini Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
                    <h4 class="font-semibold text-gray-800">Absensi Hari Ini</h4>
                    <a href="{{ route('admin.absensi.index') }}" class="text-sm text-green-700 hover:underline flex items-center">
                        Lihat Semua
                        <i class="fas fa-chevron-right ml-1 text-xs"></i>
                    </a>
                </div>
                
                <div class="p-6">
                    @if (isset($absensiHariIni) && $absensiHariIni->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead>
                                    <tr class="text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        <th class="px-4 py-3 bg-gray-50">Nama</th>
                                        <th class="px-4 py-3 bg-gray-50">Jam Masuk</th>
                                        <th class="px-4 py-3 bg-gray-50">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @foreach ($absensiHariIni as $absensi)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-4 py-3">{{ $absensi->karyawan && $absensi->karyawan->user ? $absensi->karyawan->user->name : '-' }}</td>
                                            <td class="px-4 py-3">{{ $absensi->jam_masuk ? \Carbon\Carbon::parse($absensi->jam_masuk)->format('H:i') : '-' }}</td>
                                            <td class="px-4 py-3">
                                                @if($absensi->status == 'tepat waktu')
                                                    <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">
                                                        {{ ucwords($absensi->status) }}
                                                    </span>
                                                @elseif($absensi->status == 'terlambat')
                                                    <span class="px-2 py-1 bg-yellow-100 text-yellow-800 text-xs rounded-full">
                                                        {{ ucwords($absensi->status) }}
                                                    </span>
                                                @else
                                                    <span class="px-2 py-1 bg-gray-100 text-gray-800 text-xs rounded-full">
                                                        {{ ucwords($absensi->status) }}
                                                    </span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-8">
                            <div class="w-16 h-16 bg-gray-100 rounded-full mx-auto flex items-center justify-center mb-4">
                                <i class="fas fa-calendar-day text-gray-400 text-xl"></i>
                            </div>
                            <p class="text-gray-500">Belum ada data absensi hari ini.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Second Row Cards -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Rekap Absensi Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
                    <h4 class="font-semibold text-gray-800">Rekap Absensi</h4>
                </div>
                
                <div class="p-6">
                    <form method="GET" action="{{ route('admin.absensi.index') }}" class="mb-6 bg-gray-50 p-4 rounded-lg">
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <div>
                                <label for="karyawan_id_filter" class="block text-xs font-medium text-gray-700 mb-1">Karyawan:</label>
                                <select name="karyawan_id" id="karyawan_id_filter" class="w-full text-sm rounded-lg border-gray-200 focus:border-green-500 focus:ring-green-500">
                                    <option value="">Semua Karyawan</option>
                                    @if (isset($karyawans))
                                        @foreach ($karyawans as $k_data)
                                            <option value="{{ $k_data->id }}" {{ request('karyawan_id') == $k_data->id ? 'selected' : '' }}>
                                                {{ $k_data->user->name }} ({{ $k_data->nik }})
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div>
                                <label for="bulan_filter" class="block text-xs font-medium text-gray-700 mb-1">Bulan:</label>
                                <select name="bulan" id="bulan_filter" class="w-full text-sm rounded-lg border-gray-200 focus:border-green-500 focus:ring-green-500">
                                    @if (isset($listBulan))
                                        @foreach($listBulan as $key => $namaBulan)
                                            <option value="{{ $key }}" {{ $key == ($selectedBulan ?? date('n')) ? 'selected' : '' }}>{{ $namaBulan }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div>
                                <label for="tahun_filter" class="block text-xs font-medium text-gray-700 mb-1">Tahun:</label>
                                <select name="tahun" id="tahun_filter" class="w-full text-sm rounded-lg border-gray-200 focus:border-green-500 focus:ring-green-500">
                                    @if (isset($listTahun))
                                        @foreach($listTahun as $th)
                                            <option value="{{ $th }}" {{ $th == ($selectedTahun ?? date('Y')) ? 'selected' : '' }}>{{ $th }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="flex items-end">
                                <button type="submit" class="w-full px-4 py-2 bg-green-700 text-white rounded-lg hover:bg-green-800 transition-colors text-sm">
                                    <i class="fas fa-filter mr-1"></i> Filter
                                </button>
                            </div>
                        </div>
                    </form>

                    @if (isset($absensi) && $absensi->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead>
                                    <tr class="text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        <th class="px-4 py-3 bg-gray-50">Karyawan</th>
                                        <th class="px-4 py-3 bg-gray-50">Tanggal</th>
                                        <th class="px-4 py-3 bg-gray-50">Jam Masuk</th>
                                        <th class="px-4 py-3 bg-gray-50">Jam Pulang</th>
                                        <th class="px-4 py-3 bg-gray-50">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @foreach ($absensi as $item)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-4 py-3">{{ $item->karyawan && $item->karyawan->user ? $item->karyawan->user->name : '-' }}</td>
                                            <td class="px-4 py-3">{{ \Carbon\Carbon::parse($item->tanggal)->isoFormat('DD MMM YYYY') }}</td>
                                            <td class="px-4 py-3">{{ $item->jam_masuk ? \Carbon\Carbon::parse($item->jam_masuk)->format('H:i') : '-' }}</td>
                                            <td class="px-4 py-3">{{ $item->jam_pulang ? \Carbon\Carbon::parse($item->jam_pulang)->format('H:i') : '-' }}</td>
                                            <td class="px-4 py-3">
                                                @if($item->status == 'tepat waktu')
                                                    <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">
                                                        {{ ucwords($item->status) }}
                                                    </span>
                                                @elseif($item->status == 'terlambat')
                                                    <span class="px-2 py-1 bg-yellow-100 text-yellow-800 text-xs rounded-full">
                                                        {{ ucwords($item->status) }}
                                                    </span>
                                                @else
                                                    <span class="px-2 py-1 bg-gray-100 text-gray-800 text-xs rounded-full">
                                                        {{ ucwords($item->status) }}
                                                    </span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        @if (isset($absensi) && method_exists($absensi, 'hasPages') && $absensi->hasPages())
                            <div class="mt-4">
                                {{ $absensi->appends(request()->query())->links() }}
                            </div>
                        @endif
                        
                        <div class="mt-4 flex justify-end">
                            <a href="{{ route('admin.absensi.index') }}" class="inline-flex items-center px-4 py-2 bg-green-700 text-white rounded-lg hover:bg-green-800 transition-colors text-sm font-medium">
                                <i class="fas fa-list mr-2"></i> Rekap Lengkap Absensi
                            </a>
                        </div>
                    @else
                        <div class="text-center py-8">
                            <div class="w-16 h-16 bg-gray-100 rounded-full mx-auto flex items-center justify-center mb-4">
                                <i class="fas fa-calendar-times text-gray-400 text-xl"></i>
                            </div>
                            <p class="text-gray-500">Tidak ada data absensi untuk filter yang dipilih.</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Penggajian Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
                    <h4 class="font-semibold text-gray-800">Penggajian Karyawan</h4>
                    <a href="{{ route('admin.gaji.index') }}" class="text-sm text-green-700 hover:underline flex items-center">
                        Lihat Semua
                        <i class="fas fa-chevron-right ml-1 text-xs"></i>
                    </a>
                </div>
                
                <div class="p-6">
                    <div class="mb-6 bg-gray-50 p-4 rounded-lg">
                        <h5 class="font-medium text-gray-700 mb-3">Hitung Gaji Cepat</h5>
                        <form action="{{ route('admin.gaji.hitung') }}" method="POST">
                            @csrf
                            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                <div>
                                    <label for="karyawan_id" class="block text-xs font-medium text-gray-700 mb-1">Karyawan:</label>
                                    @if (isset($karyawans))
                                        <select name="karyawan_id" id="karyawan_id" class="w-full text-sm rounded-lg border-gray-200 focus:border-green-500 focus:ring-green-500" required>
                                            <option value="">-- Pilih Karyawan --</option>
                                            @foreach ($karyawans as $karyawan)
                                                <option value="{{ $karyawan->id }}">{{ $karyawan->nama }} - {{ $karyawan->nik }}</option>
                                            @endforeach
                                        </select>
                                    @endif
                                </div>
                                <div>
                                    <label for="bulan" class="block text-xs font-medium text-gray-700 mb-1">Bulan:</label>
                                    <select name="bulan" id="bulan" class="w-full text-sm rounded-lg border-gray-200 focus:border-green-500 focus:ring-green-500" required>
                                        @if (isset($bulanList))
                                            @foreach ($bulanList as $key => $bulan)
                                                <option value="{{ $key }}" {{ date('n') == $key ? 'selected' : '' }}>{{ $bulan }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div>
                                    <label for="tahun" class="block text-xs font-medium text-gray-700 mb-1">Tahun:</label>
                                    <select name="tahun" id="tahun" class="w-full text-sm rounded-lg border-gray-200 focus:border-green-500 focus:ring-green-500" required>
                                        @if (isset($tahunList))
                                            @foreach ($tahunList as $key => $tahun)
                                                <option value="{{ $key }}" {{ date('Y') == $key ? 'selected' : '' }}>{{ $tahun }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="flex items-end">
                                    <button type="submit" class="w-full px-4 py-2 bg-green-700 text-white rounded-lg hover:bg-green-800 transition-colors text-sm">
                                        <i class="fas fa-calculator mr-1"></i> Hitung Gaji
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                    @if (isset($gajiTerbaru) && $gajiTerbaru->count() > 0)
                        <h5 class="font-medium text-gray-700 mb-3">Data Gaji Terbaru</h5>
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead>
                                    <tr class="text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        <th class="px-4 py-3 bg-gray-50">Nama</th>
                                        <th class="px-4 py-3 bg-gray-50">Periode</th>
                                        <th class="px-4 py-3 bg-gray-50">Gaji Bersih</th>
                                        <th class="px-4 py-3 bg-gray-50">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @foreach ($gajiTerbaru as $gaji)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-4 py-3">{{ $gaji->karyawan->user->name ?? 'Nama tidak tersedia' }}</td>
                                            <td class="px-4 py-3">{{ $bulanList[$gaji->bulan] ?? $gaji->bulan }} {{ $gaji->tahun }}</td>
                                            <td class="px-4 py-3 font-medium">Rp {{ number_format($gaji->gaji_bersih, 0, ',', '.') }}</td>
                                            <td class="px-4 py-3">
                                                <a href="{{ route('admin.gaji.cetak', $gaji->id) }}" class="px-3 py-1 bg-green-700 text-white text-xs rounded-lg hover:bg-green-800 transition-colors inline-flex items-center" target="_blank">
                                                    <i class="fas fa-print mr-1"></i> Cetak
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-8">
                            <div class="w-16 h-16 bg-gray-100 rounded-full mx-auto flex items-center justify-center mb-4">
                                <i class="fas fa-money-bill-wave text-gray-400 text-xl"></i>
                            </div>
                            <p class="text-gray-500">Belum ada data gaji.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-wrap justify-end gap-3 mt-6">
            <a href="{{ route('admin.karyawan.create') }}" class="inline-flex items-center px-4 py-2 bg-green-700 text-white rounded-lg hover:bg-green-800 transition-colors text-sm font-medium">
                <i class="fas fa-user-plus mr-2"></i> Tambah Karyawan
            </a>
            <a href="{{ route('admin.absensi.index') }}" class="inline-flex items-center px-4 py-2 bg-green-700 text-white rounded-lg hover:bg-green-800 transition-colors text-sm font-medium">
                <i class="fas fa-calendar-alt mr-2"></i> Rekap Absensi
            </a>
            <a href="{{ route('admin.gaji.index') }}" class="inline-flex items-center px-4 py-2 bg-green-700 text-white rounded-lg hover:bg-green-800 transition-colors text-sm font-medium">
                <i class="fas fa-money-bill-wave mr-2"></i> Penggajian
            </a>
        </div>
    </div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
@endpush