<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }} - Register</title>
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
                background: linear-gradient(135deg, #E9FFE6 50%, #316A4E 50%);
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
    <div class="w-full max-w-xl bg-primary-base rounded-3xl shadow-2xl overflow-hidden">
        <div class="p-8">
            <div class="text-center mb-8">
                <div class="mx-auto h-16 w-16 flex items-center justify-center rounded-2xl bg-primary-light shadow-lg mb-4">
                    <svg class="h-8 w-8 text-primary" fill="#316A4E" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                    </svg>
                </div>
                <h1 class="text-3xl font-extrabold text-primary tracking-tight">Buat Akun Baru</h1>
                <p class="mt-2 text-gray-600">Bergabunglah dengan kami sekarang</p>
            </div>

            <form method="POST" action="{{ route('register') }}" class="space-y-6">
                @csrf
                
                <div>
                    <label for="name" class="block text-sm font-medium text-primary mb-1">Nama Lengkap</label>
                    <input 
                        id="name" 
                        type="text" 
                        name="name" 
                        value="{{ old('name') }}" 
                        required 
                        autofocus 
                        class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 bg-primary-light/20 focus:bg-primary-base @error('name') border-red-500 @enderror"
                        placeholder="Masukkan nama lengkap Anda">
                    @error('name') 
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-primary mb-1">Email Address</label>
                    <input 
                        id="email" 
                        type="email" 
                        name="email" 
                        value="{{ old('email') }}" 
                        required 
                        class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 bg-primary-light/20 focus:bg-primary-base @error('email') border-red-500 @enderror"
                        placeholder="Masukkan alamat email">
                    @error('email') 
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="password" class="block text-sm font-medium text-primary mb-1">Password</label>
                        <input 
                            id="password" 
                            type="password" 
                            name="password" 
                            required 
                            class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 bg-primary-light/20 focus:bg-primary-base @error('password') border-red-500 @enderror"
                            placeholder="Buat password">
                        <div class="mt-2 hidden" id="passwordStrength">
                            <div class="flex space-x-1 mb-1">
                                <span class="h-1.5 w-6 rounded-full bg-gray-200 transition-colors duration-300"></span>
                                <span class="h-1.5 w-6 rounded-full bg-gray-200 transition-colors duration-300"></span>
                                <span class="h-1.5 w-6 rounded-full bg-gray-200 transition-colors duration-300"></span>
                                <span class="h-1.5 w-6 rounded-full bg-gray-200 transition-colors duration-300"></span>
                            </div>
                            <p class="text-xs text-gray-500">Kekuatan password</p>
                        </div>
                        @error('password') 
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-primary mb-1">Konfirmasi Password</label>
                        <input 
                            id="password_confirmation" 
                            type="password" 
                            name="password_confirmation" 
                            required 
                            class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 bg-primary-light/20 focus:bg-primary-base"
                            placeholder="Ulangi password">
                    </div>
                </div>

                <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-sm text-base font-medium text-primary-base bg-gradient-button focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transform transition-all duration-200 hover:-translate-y-1 hover:shadow-lg">
                    Daftar Sekarang
                </button>

                <div class="pt-4 text-center border-t border-gray-200">
                    <a href="{{ route('login') }}" class="text-primary hover:text-primary/80 font-semibold text-sm transition-colors duration-200">
                        Sudah punya akun? Masuk di sini
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Enhanced password strength indicator with custom colors
        document.getElementById('password').addEventListener('input', function() {
            const password = this.value;
            const strengthElement = document.getElementById('passwordStrength');
            const dots = strengthElement.querySelectorAll('span');
            const text = strengthElement.querySelector('p');
            
            strengthElement.style.display = password.length > 0 ? 'block' : 'none';
            
            let strength = 0;
            if (password.length >= 8) strength++;
            if (/[a-z]/.test(password) && /[A-Z]/.test(password)) strength++;
            if (/\d/.test(password)) strength++;
            if (/[!@#$%^&*(),.?":{}|<>]/.test(password)) strength++;
            
            // Custom colors matching our theme
            const colors = ['#FFB8AB', '#FFB8AB', '#E9FFE6', '#316A4E'];
            const strengthLabels = ['Lemah', 'Cukup', 'Baik', 'Kuat'];
            
            dots.forEach((dot, index) => {
                // Reset all classes first
                dot.className = 'h-1.5 w-6 rounded-full transition-colors duration-300';
                
                if (index < strength) {
                    dot.style.backgroundColor = colors[strength - 1];
                } else {
                    dot.style.backgroundColor = '#e5e7eb'; // gray-200
                }
            });
            
            if (password.length > 0) {
                text.textContent = strengthLabels[Math.max(0, strength - 1)];
                text.style.color = colors[Math.max(0, strength - 1)];
            } else {
                text.textContent = 'Kekuatan password';
                text.style.color = '#6b7280'; // gray-500
            }
        });
    </script>
</body>
</html>