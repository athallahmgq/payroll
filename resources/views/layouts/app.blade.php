<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                    },
                    colors: {
                        green: {
                            DEFAULT: '#316A4E',
                            50: '#E9FFE6',
                            100: '#d1e7d0',
                            200: '#b3d1b1',
                            300: '#95bb93',
                            400: '#77a574',
                            500: '#598f56',
                            600: '#447a41',
                            700: '#316A4E',
                            800: '#1d4025',
                            900: '#0a2b0c',
                        },
                        coral: {
                            DEFAULT: '#FFB8AB',
                            50: '#fff5f3',
                            100: '#ffece8',
                            200: '#ffd9d1',
                            300: '#ffc6ba',
                            400: '#FFB8AB',
                            500: '#ff9a89',
                            600: '#ff7c67',
                            700: '#ff5e45',
                            800: '#ff4023',
                            900: '#ff2201',
                        },
                        mint: {
                            DEFAULT: '#E9FFE6',
                            50: '#f9fff8',
                            100: '#E9FFE6',
                            200: '#d0ffc9',
                            300: '#b7ffac',
                            400: '#9eff8f',
                            500: '#85ff72',
                            600: '#6cff55',
                            700: '#53ff38',
                            800: '#3aff1b',
                            900: '#21ff00',
                        },
                    },
                },
            },
        }
    </script>
</head>
<body class="font-sans bg-gray-50 text-gray-800 antialiased">
    <div class="flex min-h-screen">
        <!-- Sidebar Toggle for Mobile -->
        <button id="sidebarToggle" class="lg:hidden fixed top-4 left-4 z-50 p-2.5 rounded-full bg-white text-green-700 shadow-lg focus:outline-none hover:bg-green-50 transition-colors border border-gray-100">
            <i class="fas fa-bars text-lg"></i>
        </button>
        
        <!-- Sidebar -->
        <nav id="sidebar" class="fixed inset-y-0 left-0 w-72 bg-white text-gray-700 shadow-xl transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out z-40">
            <div class="flex flex-col h-full">
                <div class="p-6 border-b border-gray-100">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 rounded-xl bg-green-700 flex items-center justify-center">
                            <i class="fas fa-leaf text-white"></i>
                        </div>
                        <h2 class="text-xl font-bold text-green-700">{{ config('app.name', 'Laravel') }}</h2>
                    </div>
                    @auth
                        <div class="mt-5 flex items-center p-3 bg-mint-50 rounded-xl">
                            <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center text-green-700 font-bold">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                            <div class="ml-3">
                                <div class="font-semibold text-gray-800">{{ Auth::user()->name }}</div>
                                <div class="text-xs text-gray-500">{{ ucfirst(Auth::user()->role) }}</div>
                            </div>
                        </div>
                    @endauth
                </div>
                
                <div class="flex-1 overflow-y-auto py-6 px-4">
                    @auth
                        @if(Auth::user()->role == 'admin')
                            <div class="mb-8">
                                <div class="px-3 mb-3 text-xs font-semibold tracking-wider text-gray-500 uppercase">Admin Panel</div>
                                <a href="{{ route('admin.dashboard') }}" class="flex items-center px-3 py-3 text-gray-700 hover:bg-mint-50 rounded-xl mb-2 group transition-all duration-200">
                                    <div class="mr-3 flex items-center justify-center w-9 h-9 bg-green-100 text-green-700 rounded-lg group-hover:bg-green-700 group-hover:text-white transition-colors">
                                        <i class="fas fa-chart-line"></i>
                                    </div>
                                    <span>Dashboard</span>
                                </a>
                                <a href="{{ route('admin.karyawan.index') }}" class="flex items-center px-3 py-3 text-gray-700 hover:bg-mint-50 rounded-xl mb-2 group transition-all duration-200">
                                    <div class="mr-3 flex items-center justify-center w-9 h-9 bg-green-100 text-green-700 rounded-lg group-hover:bg-green-700 group-hover:text-white transition-colors">
                                        <i class="fas fa-users"></i>
                                    </div>
                                    <span>Kelola Karyawan</span>
                                </a>
                                <a href="{{ route('admin.absensi.index') }}" class="flex items-center px-3 py-3 text-gray-700 hover:bg-mint-50 rounded-xl mb-2 group transition-all duration-200">
                                    <div class="mr-3 flex items-center justify-center w-9 h-9 bg-green-100 text-green-700 rounded-lg group-hover:bg-green-700 group-hover:text-white transition-colors">
                                        <i class="fas fa-clipboard-list"></i>
                                    </div>
                                    <span>Rekap Absensi</span>
                                </a>
                                <a href="{{ route('admin.gaji.index') }}" class="flex items-center px-3 py-3 text-gray-700 hover:bg-mint-50 rounded-xl mb-2 group transition-all duration-200">
                                    <div class="mr-3 flex items-center justify-center w-9 h-9 bg-green-100 text-green-700 rounded-lg group-hover:bg-green-700 group-hover:text-white transition-colors">
                                        <i class="fas fa-money-bill-wave"></i>
                                    </div>
                                    <span>Penggajian</span>
                                </a>
                            </div>
                        @elseif(Auth::user()->role == 'karyawan')
                            <div class="mb-8">
                                <div class="px-3 mb-3 text-xs font-semibold tracking-wider text-gray-500 uppercase">Karyawan</div>
                                <a href="{{ route('karyawan.dashboard') }}" class="flex items-center px-3 py-3 text-gray-700 hover:bg-mint-50 rounded-xl mb-2 group transition-all duration-200">
                                    <div class="mr-3 flex items-center justify-center w-9 h-9 bg-green-100 text-green-700 rounded-lg group-hover:bg-green-700 group-hover:text-white transition-colors">
                                        <i class="fas fa-chart-line"></i>
                                    </div>
                                    <span>Dashboard</span>
                                </a>
                                <a href="{{ route('karyawan.absensi.riwayat') }}" class="flex items-center px-3 py-3 text-gray-700 hover:bg-mint-50 rounded-xl mb-2 group transition-all duration-200">
                                    <div class="mr-3 flex items-center justify-center w-9 h-9 bg-green-100 text-green-700 rounded-lg group-hover:bg-green-700 group-hover:text-white transition-colors">
                                        <i class="fas fa-calendar-alt"></i>
                                    </div>
                                    <span>Riwayat Absensi</span>
                                </a>
                            </div>
                        @endif
                    @else
                        <div class="px-3 py-4 flex flex-col space-y-3">
                            <a href="{{ route('login') }}" class="flex justify-center items-center px-4 py-3 bg-coral-400 text-white rounded-xl hover:bg-coral-500 transition-colors duration-200 font-medium shadow-sm">
                                <i class="fas fa-lock mr-2"></i>
                                <span>Login</span>
                            </a>
                            <a href="{{ route('register') }}" class="flex justify-center items-center px-4 py-3 bg-green-700 text-white rounded-xl hover:bg-green-800 transition-colors duration-200 font-medium shadow-sm">
                                <i class="fas fa-user-plus mr-2"></i>
                                <span>Register</span>
                            </a>
                        </div>
                    @endauth
                </div>
                
                @auth
                <div class="p-4 border-t border-gray-100">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full flex items-center justify-center px-4 py-3 bg-gray-100 hover:bg-red-300 text-gray-700 rounded-xl transition-colors duration-200 font-medium">
                            <i class="fas fa-sign-out-alt mr-2"></i>
                            <span>Logout</span>
                        </button>
                    </form>
                </div>
                @endauth
            </div>
        </nav>
        
        <!-- Main Content Wrapper -->
        <div class="flex-1 lg:ml-72 transition-all duration-300 ease-in-out">
            <!-- Top Navigation Bar -->
            <header class="bg-white border-b border-gray-100 sticky top-0 z-30">
                <div class="flex items-center justify-between px-6 py-4">
                    <div class="lg:hidden">
                        <!-- Placeholder for mobile -->
                    </div>
                    <div class="hidden lg:block">
                        <h1 class="text-xl font-semibold text-gray-800">
                            @if(View::hasSection('header'))
                                @yield('header')
                            @else
                                Dashboard
                            @endif
                        </h1>
                    </div>
                    <div class="flex items-center space-x-3">
                        <button class="p-2 rounded-full hover:bg-gray-100 text-gray-600 transition-colors">
                            <i class="fas fa-bell"></i>
                        </button>
                        <button class="p-2 rounded-full hover:bg-gray-100 text-gray-600 transition-colors">
                            <i class="fas fa-cog"></i>
                        </button>
                    </div>
                </div>
            </header>
            
            <main class="bg-gray-50 min-h-[calc(100vh-65px)] p-6 md:p-8">
                <div class="max-w-7xl mx-auto">
                    @if(View::hasSection('header'))
                        <div class="mb-8 lg:hidden">
                            <h2 class="text-2xl font-bold text-gray-800">@yield('header')</h2>
                        </div>
                    @endif

                    @if (session('success'))
                        <div class="mb-6 p-4 rounded-xl bg-green-50 border border-green-200 text-green-700 flex items-start">
                            <i class="fas fa-check-circle mt-1 mr-3 text-green-500"></i>
                            <div>{{ session('success') }}</div>
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="mb-6 p-4 rounded-xl bg-red-50 border border-red-200 text-red-700 flex items-start">
                            <i class="fas fa-exclamation-circle mt-1 mr-3 text-red-500"></i>
                            <div>{{ session('error') }}</div>
                        </div>
                    @endif
                    @if (session('warning'))
                        <div class="mb-6 p-4 rounded-xl bg-yellow-50 border border-yellow-200 text-yellow-700 flex items-start">
                            <i class="fas fa-exclamation-triangle mt-1 mr-3 text-yellow-500"></i>
                            <div>{{ session('warning') }}</div>
                        </div>
                    @endif
                    @if (session('info'))
                        <div class="mb-6 p-4 rounded-xl bg-blue-50 border border-blue-200 text-blue-700 flex items-start">
                            <i class="fas fa-info-circle mt-1 mr-3 text-blue-500"></i>
                            <div>{{ session('info') }}</div>
                        </div>
                    @endif

                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                        @yield('content')
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script>
        // Toggle sidebar on mobile
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('-translate-x-full');
        });
        
        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(event) {
            const sidebar = document.getElementById('sidebar');
            const toggle = document.getElementById('sidebarToggle');
            
            if (window.innerWidth < 1024) { // lg breakpoint
                if (!sidebar.contains(event.target) && !toggle.contains(event.target)) {
                    sidebar.classList.add('-translate-x-full');
                }
            }
        });
        
        // Highlight active menu item
        document.addEventListener('DOMContentLoaded', function() {
            const currentUrl = window.location.pathname;
            const menuItems = document.querySelectorAll('nav a');
            
            menuItems.forEach(item => {
                if (item.getAttribute('href') === currentUrl) {
                    item.classList.add('bg-mint-50');
                    item.classList.add('text-green-700');
                    const icon = item.querySelector('div');
                    if (icon) {
                        icon.classList.remove('bg-green-100');
                        icon.classList.add('bg-green-700');
                        icon.classList.add('text-white');
                    }
                }
            });
        });
    </script>
    
    <!-- Additional styles for form elements and tables -->
    <style>
        /* Table styles */
        table { 
            @apply w-full border-collapse mt-5 rounded-xl overflow-hidden;
        }
        
        th, td { 
            @apply border-b border-gray-100 p-4 text-left;
        }
        
        th { 
            @apply bg-gray-50 font-semibold text-gray-700;
        }
        
        tr:last-child td {
            @apply border-b-0;
        }
        
        tr:hover {
            @apply bg-gray-50 transition-colors duration-200;
        }
        
        /* Button styles */
        .button, button:not([id="sidebarToggle"]):not([type="submit"]) { 
            @apply bg-green-700 text-white py-2.5 px-5 rounded-xl inline-flex items-center justify-center transition-all duration-200 hover:bg-green-800 hover:shadow-md m-1 first:ml-0 font-medium text-sm;
        }
        
        .button-green { @apply bg-green-600 hover:bg-green-700; }
        .button-red { @apply bg-coral-500 hover:bg-coral-600 text-white; }
        
        /* Form styles */
        .form-group { @apply mb-6; }
        
        label { 
            @apply block mb-2 font-medium text-gray-700 text-sm;
        }
        
        input[type="text"], 
        input[type="email"], 
        input[type="password"], 
        input[type="date"], 
        input[type="time"], 
        input[type="number"], 
        select, 
        textarea {
            @apply w-full p-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200 bg-white text-gray-700;
        }
        
        /* Pagination */
        .pagination { 
            @apply mt-6 flex justify-center;
        }
        
        .pagination li { 
            @apply inline-block mx-1;
        }
        
        .pagination li a, 
        .pagination li span { 
            @apply px-4 py-2 border border-gray-200 rounded-lg inline-block hover:bg-gray-50 transition-colors duration-200 text-sm;
        }
        
        .pagination li.active span { 
            @apply bg-green-700 text-white border-green-700;
        }
        
        /* Error message */
        .error-message { 
            @apply text-coral-600 text-sm mt-1;
        }
        
        /* Card styles */
        .card {
            @apply bg-white rounded-xl shadow-sm border border-gray-100 p-6;
        }
    </style>
</body>
</html>