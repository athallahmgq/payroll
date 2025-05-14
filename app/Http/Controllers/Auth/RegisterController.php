<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered; // Untuk event jika diperlukan

class RegisterController extends Controller
{
    public function create()
    {
        return view('auth.register'); // Anda perlu membuat view ini
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            // 'role' tidak perlu di form, default 'karyawan'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password, // Model User sudah punya cast 'hashed'
            'role' => 'karyawan', // Default untuk registrasi publik
        ]);

        event(new Registered($user)); // Opsional: trigger event
        Auth::login($user);

        // Arahkan ke dashboard yang sesuai
        if ($user->role == 'karyawan' && !$user->karyawan) {
             // Jika karyawan baru dan belum ada profil karyawan,
             // arahkan ke halaman untuk melengkapi profil karyawan.
             // Untuk sementara, kita arahkan ke dashboard karyawan yang akan menghandle ini.
             return redirect()->route('karyawan.dashboard')->with('info', 'Silakan lengkapi data karyawan Anda.');
        } elseif($user->role == 'karyawan') {
             return redirect()->route('karyawan.dashboard');
        }

        return redirect()->route('home'); // Fallback
    }
}
