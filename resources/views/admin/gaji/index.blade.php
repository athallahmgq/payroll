@extends('layouts.app')

@section('content')

<div class="space-y-6">
<!-- Summary Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-4">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden p-5">
        <div class="flex items-center">
            <div class="w-12 h-12 rounded-lg bg-green-100 flex items-center justify-center text-green-700 mr-4">
                <i class="fas fa-users text-xl"></i>
            </div>
            <div>
                <p class="text-sm text-gray-500">Total Karyawan</p>
                <h4 class="text-xl font-bold text-gray-800">{{ count($karyawans) }}</h4>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden p-5">
        <div class="flex items-center">
            <div class="w-12 h-12 rounded-lg bg-blue-100 flex items-center justify-center text-blue-700 mr-4">
                <i class="fas fa-calendar-check text-xl"></i>
            </div>
            <div>
                <p class="text-sm text-gray-500">Periode Aktif</p>
                <h4 class="text-xl font-bold text-gray-800">{{ $bulanList[date('n')] }} {{ date('Y') }}</h4>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden p-5">
        <div class="flex items-center">
            <div class="w-12 h-12 rounded-lg bg-yellow-100 flex items-center justify-center text-yellow-700 mr-4">
                <i class="fas fa-money-bill-wave text-xl"></i>
            </div>
            <div>
                <p class="text-sm text-gray-500">Total Pengeluaran Gaji</p>
                <h4 class="text-xl font-bold text-gray-800">
                    Rp {{ number_format($gajis->sum('gaji_bersih'), 0, ',', '.') }}
                </h4>
            </div>
        </div>
    </div>
</div>
<!-- Salary Calculation Card -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="p-5 border-b border-gray-100">
        <div class="flex items-center">
            <div class="w-8 h-8 rounded-lg bg-green-100 flex items-center justify-center text-green-700 mr-3">
                <i class="fas fa-calculator"></i>
            </div>
            <h3 class="text-lg font-semibold text-gray-800">Hitung Gaji Karyawan</h3>
        </div>
    </div>
    
    <div class="p-5">
        <form action="{{ route('admin.gaji.hitung') }}" method="POST" class="space-y-4 md:space-y-0 md:flex md:flex-wrap md:items-end md:gap-4">
            @csrf
            <div class="w-full md:w-auto md:flex-1">
                <label for="karyawan_id" class="block text-sm font-medium text-gray-700 mb-1">Karyawan</label>
                <select name="karyawan_id" id="karyawan_id" class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-green-500" required>
                    <option value="">-- Pilih Karyawan --</option>
                    @foreach ($karyawans as $karyawan)
                        <option value="{{ $karyawan->id }}">{{ $karyawan->nama }} - {{ $karyawan->nik }}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="w-full md:w-auto">
                <label for="bulan" class="block text-sm font-medium text-gray-700 mb-1">Bulan</label>
                <select name="bulan" id="bulan" class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-green-500" required>
                    @foreach ($bulanList as $key => $bulan)
                        <option value="{{ $key }}" {{ date('n') == $key ? 'selected' : '' }}>{{ $bulan }}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="w-full md:w-auto">
                <label for="tahun" class="block text-sm font-medium text-gray-700 mb-1">Tahun</label>
                <select name="tahun" id="tahun" class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-green-500" required>
                    @foreach ($tahunList as $key => $tahun)
                        <option value="{{ $key }}" {{ date('Y') == $key ? 'selected' : '' }}>{{ $tahun }}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="w-full md:w-auto">
                <button type="submit" class="w-full md:w-auto px-4 py-2.5 bg-green-700 text-white rounded-lg hover:bg-green-800 transition-colors font-medium flex items-center justify-center">
                    <i class="fas fa-calculator mr-2"></i> Hitung Gaji
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Salary Data Card -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="p-5 border-b border-gray-100">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <div class="w-8 h-8 rounded-lg bg-green-100 flex items-center justify-center text-green-700 mr-3">
                    <i class="fas fa-money-bill-wave"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-800">Data Gaji Karyawan</h3>
            </div>
            
            <div class="flex items-center">
                <button id="clearButton" class="inline-flex items-center px-3 py-1.5 bg-red-100 hover:bg-red-200 text-red-700 rounded-lg transition-colors text-sm font-medium">
                    <i class="fas fa-trash mr-1.5"></i> Clear
                </button>
            </div>
        </div>
    </div>
    
    <div class="overflow-x-auto">
        <table  class="w-full" id="gaji-table">
            <thead>
                <tr class="text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    <th class="px-4 py-3 bg-gray-50">No</th>
                    <th class="px-4 py-3 bg-gray-50">Nama Karyawan</th>
                    <th class="px-4 py-3 bg-gray-50">NIK</th>
                    <th class="px-4 py-3 bg-gray-50">Periode</th>
                    <th class="px-4 py-3 bg-gray-50">Kehadiran</th>
                    <th class="px-4 py-3 bg-gray-50">Gaji Pokok</th>
                    <th class="px-4 py-3 bg-gray-50">Potongan</th>
                    <th class="px-4 py-3 bg-gray-50">Gaji Bersih</th>
                    <th class="px-4 py-3 bg-gray-50">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach ($gajis as $index => $gaji)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-4 py-3 text-gray-600">{{ $index + 1 }}</td>
                    <td class="px-4 py-3">
                        <div class="flex items-center">
                            <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center text-green-700 font-bold mr-3">
                                {{ substr($gaji->karyawan->nama ?? 'N', 0, 1) }}
                            </div>
                            <div class="font-medium text-gray-800">
                                {{ $gaji->karyawan->nama ?? 'Nama tidak tersedia' }}
                            </div>
                        </div>
                    </td>
                    <td class="px-4 py-3 text-gray-600">{{ $gaji->karyawan->nik ?? 'N/A' }}</td>
                    <td class="px-4 py-3 text-gray-600">{{ $bulanList[$gaji->bulan] }} {{ $gaji->tahun }}</td>
                    <td class="px-4 py-3">
                        <div class="space-y-1">
                            <div class="flex items-center">
                                <span class="w-2 h-2 rounded-full bg-green-500 mr-2"></span>
                                <span class="text-sm">Hadir: <span class="font-medium">{{ $gaji->total_hadir }} kali</span></span>
                            </div>
                            <div class="flex items-center">
                                <span class="w-2 h-2 rounded-full bg-blue-500 mr-2"></span>
                                <span class="text-sm">Izin: <span class="font-medium">{{ $gaji->total_izin }} kali</span></span>
                            </div>
                            <div class="flex items-center">
                                <span class="w-2 h-2 rounded-full bg-yellow-500 mr-2"></span>
                                <span class="text-sm">Sakit: <span class="font-medium">{{ $gaji->total_sakit }} kali</span></span>
                            </div>
                            <div class="flex items-center">
                                <span class="w-2 h-2 rounded-full bg-red-500 mr-2"></span>
                                <span class="text-sm">Tanpa Ket: <span class="font-medium">{{ $gaji->total_tanpa_keterangan }} kali</span></span>
                            </div>
                        </div>
                    </td>
                    <td class="px-4 py-3 font-medium text-gray-800">Rp {{ number_format($gaji->gaji_pokok, 0, ',', '.') }}</td>
                    <td class="px-4 py-3 font-medium text-red-600">Rp {{ number_format($gaji->potongan, 0, ',', '.') }}</td>
                    <td class="px-4 py-3 font-medium text-green-700">Rp {{ number_format($gaji->gaji_bersih, 0, ',', '.') }}</td>
                    <td class="px-4 py-3">
                        <a href="{{ route('admin.gaji.cetak', $gaji->id) }}" class="inline-flex items-center px-3 py-1.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-xs font-medium" target="_blank">
                            <i class="fas fa-print mr-1.5"></i> Cetak Slip
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    @if(count($gajis) == 0)
    <div class="text-center py-12">
        <div class="w-20 h-20 bg-gray-100 rounded-full mx-auto flex items-center justify-center mb-4">
            <i class="fas fa-money-bill-slash text-gray-400 text-2xl"></i>
        </div>
        <h3 class="text-lg font-medium text-gray-800 mb-2">Data gaji belum ada</h3>
        <p class="text-gray-500">Silahkan pilih karyawan dan periode untuk menghitung gaji</p>
    </div>
    @endif
</div>

<!-- Clear Confirmation Modal -->
<div id="clearModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-50">
    <div class="bg-white rounded-lg p-6 max-w-md mx-4">
        <div class="flex items-center mb-4">
            <div class="w-10 h-10 rounded-full bg-red-100 flex items-center justify-center mr-3">
                <i class="fas fa-exclamation-triangle text-red-600"></i>
            </div>
            <h3 class="text-lg font-semibold text-gray-900">Konfirmasi Hapus Data</h3>
        </div>
        <p class="text-gray-600 mb-6">Apakah Anda yakin ingin menghapus semua data gaji? Tindakan ini tidak dapat dibatalkan.</p>
        <div class="flex justify-end space-x-3">
            <button id="cancelClear" class="px-4 py-2 text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300 transition-colors">
                Batal
            </button>
            <form id="clearForm" action="{{ route('admin.gaji.clear') }}" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                    <i class="fas fa-trash mr-1"></i> Hapus Semua
                </button>
            </form>
        </div>
    </div>
</div>
</div> @endsection
@push('styles')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"> <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.tailwindcss.min.css"> @endpush
@push('scripts')

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script> <script src="https://cdn.datatables.net/1.13.6/js/dataTables.tailwindcss.min.js"></script> <script> $(document).ready(function() { // Initialize DataTable $('#gaji-table').DataTable({ "ordering": false, "language": { "search": "Cari:", "lengthMenu": "Tampilkan _MENU_ data", "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ data", "infoEmpty": "Tidak ada data yang ditampilkan", "infoFiltered": "(difilter dari _MAX_ total data)", "zeroRecords": "Tidak ada data yang cocok", "paginate": { "first": "Pertama", "last": "Terakhir", "next": "Selanjutnya", "previous": "Sebelumnya" } } }); // Clear button modal functionality const clearButton = document.getElementById('clearButton'); const clearModal = document.getElementById('clearModal'); const cancelClear = document.getElementById('cancelClear'); const clearForm = document.getElementById('clearForm'); // Show modal when clear button clicked clearButton.addEventListener('click', function(e) { e.preventDefault(); clearModal.classList.remove('hidden'); clearModal.classList.add('flex'); }); // Hide modal when cancel button clicked cancelClear.addEventListener('click', function(e) { e.preventDefault(); clearModal.classList.add('hidden'); clearModal.classList.remove('flex'); }); // Close modal when clicking outside clearModal.addEventListener('click', function(e) { if (e.target === clearModal) { clearModal.classList.add('hidden'); clearModal.classList.remove('flex'); } }); // Handle form submission clearForm.addEventListener('submit', function(e) { e.preventDefault(); // Show loading state const submitButton = clearForm.querySelector('button[type="submit"]'); const originalText = submitButton.innerHTML; submitButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i> Menghapus...'; submitButton.disabled = true; // Create FormData and submit via fetch const formData = new FormData(clearForm); fetch(clearForm.action, { method: 'POST', body: formData, headers: { 'X-Requested-With': 'XMLHttpRequest', } }) .then(response => response.json()) .then(data => { if (data.success) { // Hide modal clearModal.classList.add('hidden'); clearModal.classList.remove('flex'); // Show success message (you can implement a toast notification here) alert('Data gaji berhasil dihapus!'); // Reload page to show updated data window.location.reload(); } else { alert('Gagal menghapus data: ' + (data.message || 'Terjadi kesalahan')); } }) .catch(error => { console.error('Error:', error); alert('Terjadi kesalahan saat menghapus data'); }) .finally(() => { // Restore button state submitButton.innerHTML = originalText; submitButton.disabled = false; }); }); }); </script>
@endpush

