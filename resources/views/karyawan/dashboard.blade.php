@extends('layouts.app')

@section('header', 'Dashboard Karyawan')

@section('content')
<div class="space-y-6">
    <!-- Welcome Banner -->
    <div class="bg-gradient-to-r from-green-700 to-green-600 rounded-xl shadow-lg overflow-hidden">
        <div class="px-6 py-8 md:px-8">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-white rounded-full p-3 shadow-md">
                    <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center text-green-700 text-xl font-bold">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                </div>
                <div class="ml-5">
                    <h2 class="text-xl md:text-2xl font-bold text-white">Selamat Datang, {{ Auth::user()->name }}!</h2>
                    <p class="text-green-100 mt-1">{{ \Carbon\Carbon::now()->isoFormat('dddd, D MMMM YYYY') }}</p>
                </div>
            </div>
        </div>
    </div>

    @if ($karyawan)
        <!-- Employee Information Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-5 border-b border-gray-100">
                <div class="flex items-center">
                    <div class="w-8 h-8 rounded-lg bg-green-100 flex items-center justify-center text-green-700 mr-3">
                        <i class="fas fa-id-card"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-800">Informasi Karyawan</h3>
                </div>
            </div>
            <div class="p-5">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="flex flex-col space-y-1">
                        <span class="text-sm text-gray-500">NIK</span>
                        <span class="font-medium">{{ $karyawan->nik }}</span>
                    </div>
                    <div class="flex flex-col space-y-1">
                        <span class="text-sm text-gray-500">Posisi</span>
                        <span class="font-medium">{{ $karyawan->posisi }}</span>
                    </div>
                    <div class="flex flex-col space-y-1">
                        <span class="text-sm text-gray-500">Tanggal Masuk</span>
                        <span class="font-medium">{{ \Carbon\Carbon::parse($karyawan->tanggal_masuk)->isoFormat('DD MMMM YYYY') }}</span>
                    </div>
                    <div class="flex flex-col space-y-1">
                        <span class="text-sm text-gray-500">Gaji Pokok</span>
                        <span class="font-medium text-green-700">Rp {{ number_format($karyawan->gaji_pokok, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Today's Attendance Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-5 border-b border-gray-100">
                <div class="flex items-center">
                    <div class="w-8 h-8 rounded-lg bg-green-100 flex items-center justify-center text-green-700 mr-3">
                        <i class="fas fa-clock"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-800">Presensi Hari Ini</h3>
                </div>
            </div>
            <div class="p-5">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Clock In Status -->
                    <div class="bg-gray-50 rounded-xl p-5 relative overflow-hidden">
                        @if (!$absensiHariIni || !$absensiHariIni->jam_masuk)
                            <div class="absolute top-0 right-0 w-24 h-24 -mr-8 -mt-8 bg-yellow-100 rounded-full opacity-50"></div>
                            <div class="relative">
                                <div class="text-sm text-gray-500 mb-1">Presensi Masuk</div>
                                <div class="text-lg font-semibold text-yellow-600 mb-4">Belum Absen</div>
                                <form method="POST" action="{{ route('karyawan.absensi.clockin') }}">
                                    @csrf
                                    <button type="submit" class="px-4 py-2 bg-green-700 text-white rounded-lg hover:bg-green-800 transition-colors font-medium flex items-center">
                                        <i class="fas fa-sign-in-alt mr-2"></i> Presensi Masuk
                                    </button>
                                </form>
                            </div>
                        @else
                            <div class="absolute top-0 right-0 w-24 h-24 -mr-8 -mt-8 bg-green-100 rounded-full opacity-50"></div>
                            <div class="relative">
                                <div class="text-sm text-gray-500 mb-1">Presensi Masuk</div>
                                <div class="text-lg font-semibold text-green-700 mb-1">{{ \Carbon\Carbon::parse($absensiHariIni->jam_masuk)->format('H:i:s') }}</div>
                                <div class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <i class="fas fa-check-circle mr-1"></i> Sudah Absen
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Clock Out Status -->
                    <div class="bg-gray-50 rounded-xl p-5 relative overflow-hidden">
                        @if ($absensiHariIni && $absensiHariIni->jam_masuk && !$absensiHariIni->jam_pulang)
                            <div class="absolute top-0 right-0 w-24 h-24 -mr-8 -mt-8 bg-yellow-100 rounded-full opacity-50"></div>
                            <div class="relative">
                                <div class="text-sm text-gray-500 mb-1">Presensi Pulang</div>
                                <div class="text-lg font-semibold text-yellow-600 mb-4">Belum Absen</div>
                                <form method="POST" action="{{ route('karyawan.absensi.clockout') }}">
                                    @csrf
                                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium flex items-center">
                                        <i class="fas fa-sign-out-alt mr-2"></i> Presensi Pulang
                                    </button>
                                </form>
                            </div>
                        @elseif ($absensiHariIni && $absensiHariIni->jam_pulang)
                            <div class="absolute top-0 right-0 w-24 h-24 -mr-8 -mt-8 bg-green-100 rounded-full opacity-50"></div>
                            <div class="relative">
                                <div class="text-sm text-gray-500 mb-1">Presensi Pulang</div>
                                <div class="text-lg font-semibold text-green-700 mb-1">{{ \Carbon\Carbon::parse($absensiHariIni->jam_pulang)->format('H:i:s') }}</div>
                                <div class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <i class="fas fa-check-circle mr-1"></i> Sudah Absen
                                </div>
                            </div>
                        @elseif (!$absensiHariIni || !$absensiHariIni->jam_masuk)
                            <div class="absolute top-0 right-0 w-24 h-24 -mr-8 -mt-8 bg-gray-200 rounded-full opacity-50"></div>
                            <div class="relative">
                                <div class="text-sm text-gray-500 mb-1">Presensi Pulang</div>
                                <div class="text-lg font-semibold text-gray-500 mb-1">Belum bisa absen pulang</div>
                                <div class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                    <i class="fas fa-clock mr-1"></i> Lakukan presensi masuk terlebih dahulu
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                @if ($absensiHariIni && $absensiHariIni->status !== 'hadir')
                    <div class="mt-5 bg-blue-50 border border-blue-100 rounded-xl p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="fas fa-info-circle text-blue-500"></i>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-blue-800">Status hari ini: <span class="font-semibold">{{ ucwords($absensiHariIni->status) }}</span></h3>
                                @if ($absensiHariIni->keterangan)
                                    <div class="mt-2 text-sm text-blue-700">
                                        <p>Keterangan: {{ $absensiHariIni->keterangan }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Recent Attendance History Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-5 border-b border-gray-100">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-8 h-8 rounded-lg bg-green-100 flex items-center justify-center text-green-700 mr-3">
                            <i class="fas fa-history"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-800">Riwayat Absensi Terakhir</h3>
                    </div>
                    <a href="{{ route('karyawan.absensi.riwayat') }}" class="text-sm text-green-700 hover:text-green-800 flex items-center">
                        Lihat Semua <i class="fas fa-chevron-right ml-1 text-xs"></i>
                    </a>
                </div>
            </div>
            <div class="p-5">
                @if ($riwayatTerakhir && $riwayatTerakhir->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr class="text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <th class="px-4 py-3 bg-gray-50">Tanggal</th>
                                    <th class="px-4 py-3 bg-gray-50">Jam Masuk</th>
                                    <th class="px-4 py-3 bg-gray-50">Jam Pulang</th>
                                    <th class="px-4 py-3 bg-gray-50">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach ($riwayatTerakhir as $absensi)
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-4 py-3 whitespace-nowrap">{{ \Carbon\Carbon::parse($absensi->tanggal)->isoFormat('D MMM YYYY') }}</td>
                                        <td class="px-4 py-3 whitespace-nowrap">{{ $absensi->jam_masuk ? \Carbon\Carbon::parse($absensi->jam_masuk)->format('H:i') : '-' }}</td>
                                        <td class="px-4 py-3 whitespace-nowrap">{{ $absensi->jam_pulang ? \Carbon\Carbon::parse($absensi->jam_pulang)->format('H:i') : '-' }}</td>
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
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-8">
                        <div class="w-16 h-16 bg-gray-100 rounded-full mx-auto flex items-center justify-center mb-4">
                            <i class="fas fa-calendar-times text-gray-400 text-xl"></i>
                        </div>
                        <h3 class="text-base font-medium text-gray-800 mb-1">Belum ada riwayat absensi</h3>
                        <p class="text-sm text-gray-500">Riwayat absensi Anda akan muncul di sini</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Recent Salary History Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-5 border-b border-gray-100">
                <div class="flex items-center">
                    <div class="w-8 h-8 rounded-lg bg-green-100 flex items-center justify-center text-green-700 mr-3">
                        <i class="fas fa-money-bill-wave"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-800">Riwayat Gaji Terakhir</h3>
                </div>
            </div>
            <div class="p-5">
                @if (isset($riwayatGaji) && $riwayatGaji->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr class="text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <th class="px-4 py-3 bg-gray-50">Periode</th>
                                    <th class="px-4 py-3 bg-gray-50">Gaji Pokok</th>
                                    <th class="px-4 py-3 bg-gray-50">Potongan</th>
                                    <th class="px-4 py-3 bg-gray-50">Gaji Bersih</th>
                                    <th class="px-4 py-3 bg-gray-50">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach ($riwayatGaji as $gaji)
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-4 py-3 whitespace-nowrap">{{ $bulanList[$gaji->bulan] ?? $gaji->bulan }} {{ $gaji->tahun }}</td>
                                        <td class="px-4 py-3 whitespace-nowrap">Rp {{ number_format($gaji->gaji_pokok, 0, ',', '.') }}</td>
                                        <td class="px-4 py-3 whitespace-nowrap text-red-600">Rp {{ number_format($gaji->potongan, 0, ',', '.') }}</td>
                                        <td class="px-4 py-3 whitespace-nowrap text-green-700 font-medium">Rp {{ number_format($gaji->gaji_bersih, 0, ',', '.') }}</td>
                                        <td class="px-4 py-3 whitespace-nowrap">
                                            @if(isset($gaji->id))
                                                <a href="{{ route('karyawan.gaji.slip', $gaji->id) }}" class="inline-flex items-center px-3 py-1.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-xs font-medium" target="_blank">
                                                    <i class="fas fa-print mr-1.5"></i> Lihat Slip Gaji
                                                </a>
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
                            <i class="fas fa-money-bill-slash text-gray-400 text-xl"></i>
                        </div>
                        <h3 class="text-base font-medium text-gray-800 mb-1">Belum ada riwayat gaji</h3>
                        <p class="text-sm text-gray-500">Riwayat gaji Anda akan muncul di sini</p>
                    </div>
                @endif
            </div>
        </div>

    @else
        <!-- Incomplete Profile Alert -->
        <div class="bg-white rounded-xl shadow-sm border-l-4 border-blue-500 overflow-hidden">
            <div class="p-5">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-info-circle text-blue-500 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-medium text-blue-800">Data Profil Belum Lengkap</h3>
                        <div class="mt-2 text-sm text-blue-700">
                            <p>Data profil karyawan Anda (NIK, Posisi, dll.) belum lengkap. Silakan lengkapi data Anda untuk mengakses fitur absensi.</p>
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('karyawan.profile.complete.form') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium">
                                <i class="fas fa-user-edit mr-2"></i> Lengkapi Profil Karyawan
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
@endpush