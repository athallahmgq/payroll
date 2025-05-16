@extends('layouts.guest')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
  <div class="max-w-md w-full space-y-8 bg-white p-8 rounded-lg shadow-md">
    <div class="text-center">
      <h2 class="mt-6 text-3xl font-extrabold text-gray-900">Login</h2>
    </div>

    @if ($errors->any())
      <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4 rounded" role="alert">
        <p>Email atau password salah.</p>
      </div>
    @endif

    @if (session('error'))
      <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4 rounded" role="alert">
        <p>{{ session('error') }}</p>
      </div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="mt-8 space-y-6">
      @csrf
      <div class="rounded-md -space-y-px">
        <div class="mb-4">
          <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
          <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus 
                 class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm">
        </div>

        <div class="mb-4">
          <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
          <input id="password" name="password" type="password" required 
                 class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm">
        </div>
      </div>

      <div class="flex items-center">
        <input id="remember" name="remember" type="checkbox" {{ old('remember') ? 'checked' : '' }}
               class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
        <label for="remember" class="ml-2 block text-sm text-gray-900">
          Ingat Saya
        </label>
      </div>

      <div>
        <button type="submit" 
                class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
          Login
        </button>
      </div>
      
      <div class="text-center mt-4">
        <a href="{{ route('register') }}" class="font-medium text-indigo-600 hover:text-indigo-500">
          Belum punya akun? Register
        </a>
      </div>
    </form>
  </div>
</div>
@endsection