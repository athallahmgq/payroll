<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }} - Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                    colors: {
                        primary: {
                            DEFAULT: '#316A4E',
                            light: '#E9FFE6',
                            accent: '#FFB8AB',
                            base: '#FFFFFF',
                        },
                    },
                },
            },
        }
    </script>
    <style type="text/tailwindcss">
        @layer utilities {
            .bg-gradient-custom {
                background: linear-gradient(135deg, #316A4E 50%, #E9FFE6 50%);
            }
            .bg-gradient-button {
                background: linear-gradient(to right, #316A4E, #316A4E);
            }
            .bg-gradient-button:hover {
                background: linear-gradient(to right, #265040, #265040);
            }
        }
    </style>
</head>
<body class="font-sans antialiased bg-gradient-custom min-h-screen flex items-center justify-center p-4 sm:p-6 md:p-8">
    <div class="w-full max-w-md bg-primary-base rounded-3xl shadow-2xl overflow-hidden">
        <div class="p-8">
            <div class="text-center mb-8">
                <div class="mx-auto h-16 w-16 flex items-center justify-center rounded-2xl bg-primary shadow-lg mb-4">
                    <svg class="h-8 w-8 text-primary-light" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                    </svg>
                </div>
                <h1 class="text-3xl font-extrabold text-primary tracking-tight">Selamat Datang</h1>
                <p class="mt-2 text-gray-600">Masuk ke akun Anda</p>
            </div>

            @if ($errors->any())
                <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl">
                    <p>Email atau password salah.</p>
                </div>
            @endif

            @if (session('error'))
                <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl">
                    <p>{{ session('error') }}</p>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf
                
                <div>
                    <label for="email" class="block text-sm font-medium text-primary mb-1">Email Address</label>
                    <input 
                        id="email" 
                        name="email" 
                        type="email" 
                        value="{{ old('email') }}" 
                        required 
                        autofocus 
                        class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 bg-primary-light/20 focus:bg-primary-base"
                        placeholder="Masukkan email Anda">
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-primary mb-1">Password</label>
                    <input 
                        id="password" 
                        name="password" 
                        type="password" 
                        required 
                        class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 bg-primary-light/20 focus:bg-primary-base"
                        placeholder="Masukkan password Anda">
                </div>

                <div class="flex items-center">
                    <input 
                        id="remember" 
                        name="remember" 
                        type="checkbox" 
                        {{ old('remember') ? 'checked' : '' }}
                        class="h-5 w-5 text-primary border-gray-300 rounded focus:ring-primary">
                    <label for="remember" class="ml-2 block text-sm text-gray-700">
                        Ingat saya
                    </label>
                </div>

                <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-sm text-base font-medium text-primary-base bg-gradient-button focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transform transition-all duration-200 hover:-translate-y-1 hover:shadow-lg">
                    Masuk
                </button>

                <div class="pt-4 text-center border-t border-gray-200">
                    <a href="{{ route('register') }}" class="text-primary hover:text-primary/80 font-semibold text-sm transition-colors duration-200">
                        Belum punya akun? Daftar sekarang
                    </a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>