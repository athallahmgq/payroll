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
        
        <div class="grid grid-cols-1 gap-6">
            <!-- Absensi Hari Ini Card -->
            
            <!-- Quick Actions Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h4 class="font-semibold text-gray-800">Aksi Cepat</h4>
                </div>
                
                <div class="p-6">
                    <div class="grid grid-cols-1 gap-3">
                        <a href="{{ route('admin.absensi.index') }}" class="flex items-center justify-between p-4 bg-green-50 rounded-lg hover:bg-green-100 transition-colors">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-calendar-alt text-green-600"></i>
                                </div>
                                <div>
                                    <h5 class="font-medium text-gray-800">Rekap Absensi</h5>
                                    <p class="text-sm text-gray-500">Lihat laporan kehadiran</p>
                                </div>
                            </div>
                            <i class="fas fa-chevron-right text-gray-400"></i>
                        </a>

                        <a href="{{ route('admin.gaji.index') }}" class="flex items-center justify-between p-4 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-money-bill-wave text-blue-600"></i>
                                </div>
                                <div>
                                    <h5 class="font-medium text-gray-800">Penggajian</h5>
                                    <p class="text-sm text-gray-500">Kelola gaji karyawan</p>
                                </div>
                            </div>
                            <i class="fas fa-chevron-right text-gray-400"></i>
                        </a>

                        <button onclick="toggleEmployeeForm()" class="flex items-center justify-between p-4 bg-purple-50 rounded-lg hover:bg-purple-100 transition-colors text-left w-full">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-user-plus text-purple-600"></i>
                                </div>
                                <div>
                                    <h5 class="font-medium text-gray-800">Tambah Karyawan</h5>
                                    <p class="text-sm text-gray-500">Daftarkan karyawan baru</p>
                                </div>
                            </div>
                            <i class="fas fa-chevron-right text-gray-400"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Employee Detail Modal -->
    <div id="employee-detail-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden flex items-center justify-center z-50">
        <div class="bg-white rounded-lg max-w-2xl w-full mx-4 max-h-96 overflow-y-auto">
            <div class="flex items-center justify-between p-6 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Detail Karyawan</h3>
                <button onclick="closeEmployeeDetail()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div id="employee-detail-content" class="p-6">
                <!-- Content will be loaded here -->
            </div>
        </div>
    </div>

    <!-- Employee Edit Modal -->
    <div id="employee-edit-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden flex items-center justify-center z-50">
        <div class="bg-white rounded-lg max-w-4xl w-full mx-4 max-h-96 overflow-y-auto">
            <div class="flex items-center justify-between p-6 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Edit Karyawan</h3>
                <button onclick="closeEmployeeEdit()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div id="employee-edit-content" class="p-6">
                <!-- Content will be loaded here -->
            </div>
        </div>
    </div>

    <script>
        // Toggle employee form
        function toggleEmployeeForm() {
            const form = document.getElementById('employee-form');
            if (form.classList.contains('hidden')) {
                form.classList.remove('hidden');
                form.scrollIntoView({ behavior: 'smooth' });
            } else {
                form.classList.add('hidden');
            }
        }

        // Search and filter functionality
        document.getElementById('employee-search').addEventListener('keyup', filterEmployees);
        document.getElementById('position-filter').addEventListener('change', filterEmployees);

        function filterEmployees() {
            const searchTerm = document.getElementById('employee-search').value.toLowerCase();
            const positionFilter = document.getElementById('position-filter').value.toLowerCase();
            const rows = document.querySelectorAll('.employee-row');

            rows.forEach(row => {
                const name = row.getAttribute('data-name');
                const position = row.getAttribute('data-position');
                const matchesSearch = name.includes(searchTerm);
                const matchesPosition = positionFilter === '' || position === positionFilter;

                if (matchesSearch && matchesPosition) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }

        // Show employee detail
        function showEmployeeDetail(id) {
            fetch(`/admin/karyawan/${id}`)
                .then(response => response.text())
                .then(html => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');
                    const content = doc.querySelector('#content');
                    
                    document.getElementById('employee-detail-content').innerHTML = content.innerHTML;
                    document.getElementById('employee-detail-modal').classList.remove('hidden');
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error loading employee details');
                });
        }

        function closeEmployeeDetail() {
            document.getElementById('employee-detail-modal').classList.add('hidden');
        }

        // Edit employee
        function editEmployee(id) {
            fetch(`/admin/karyawan/${id}/edit`)
                .then(response => response.text())
                .then(html => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');
                    const content = doc.querySelector('#content');
                    
                    document.getElementById('employee-edit-content').innerHTML = content.innerHTML;
                    document.getElementById('employee-edit-modal').classList.remove('hidden');
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error loading employee edit form');
                });
        }

        function closeEmployeeEdit() {
            document.getElementById('employee-edit-modal').classList.add('hidden');
        }

        // Close modals when clicking outside
        document.getElementById('employee-detail-modal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeEmployeeDetail();
            }
        });

        document.getElementById('employee-edit-modal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeEmployeeEdit();
            }
        });
    </script>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
@endpush