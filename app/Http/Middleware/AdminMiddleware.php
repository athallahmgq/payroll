<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response; // Import Response

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response // Tambahkan : Response
    {
        /** @var \App\Models\User|null $user */
        $user = Auth::user();

        if (Auth::check() && $user && $user->role === 'admin') { // Perbaikan logika isAdmin
            return $next($request);
        }

        if (Auth::check()) {
            Auth::logout();
            return redirect('/login')->with('error', 'Anda tidak memiliki hak akses ke halaman ini.');
        }

        return redirect('/login')->with('error', 'Silakan login terlebih dahulu.');
    }
}
