<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Models\Karyawan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule; 

class KaryawanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $karyawans = Karyawan::orderBy('user_id', 'asc')->paginate(10); 
        return view('admin.karyawan.index', compact('karyawans'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.karyawan.create');
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            // Validasi untuk User
            'name' => 'required|string|max:255', // Asumsi ini adalah nama untuk tabel User
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',

            // Validasi untuk Karyawan
            'nik' => 'required|string|max:50|unique:karyawan,nik',
            'alamat' => 'nullable|string',
            'no_telepon' => 'nullable|string|max:20',
            'posisi' => 'required|string|max:100',
            'tanggal_masuk' => 'nullable|date',
            'gaji_pokok' => 'nullable|numeric|min:0',
        ]);

        // 1. Buat User terlebih dahulu
        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'role' => 'karyawan', // Set role default
        ]);

        // 2. Buat Karyawan dan hubungkan dengan User yang baru dibuat
        Karyawan::create([
            'user_id' => $user->id,
            'nik' => $validatedData['nik'],
            'alamat' => $validatedData['alamat'],
            'no_telepon' => $validatedData['no_telepon'],
            'posisi' => $validatedData['posisi'],
            'tanggal_masuk' => $validatedData['tanggal_masuk'],
            'gaji_pokok' => $validatedData['gaji_pokok'],
        ]);

        return redirect()->route('admin.karyawan.index')
                         ->with('success', 'Karyawan berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Karyawan $karyawan)
    {
        return view('admin.karyawan.show', compact('karyawan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Karyawan $karyawan)
    {
        
        $karyawan->load('user');
        return view('admin.karyawan.edit', compact('karyawan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Karyawan $karyawan)
{
    $validatedData = $request->validate([
        // Validasi untuk User
        'name' => 'required|string|max:255',
        'email' => [
            'required',
            'string',
            'email',
            'max:255',
            Rule::unique('users')->ignore($karyawan->user_id), // Abaikan email user saat ini
        ],
        'password' => 'nullable|string|min:8|confirmed', // Password opsional

        // Validasi untuk Karyawan
        'nik' => [
            'required',
            'string',
            'max:50',
            Rule::unique('karyawan')->ignore($karyawan->id), // Abaikan NIK karyawan saat ini
        ],
        'alamat' => 'nullable|string',
        'no_telepon' => 'nullable|string|max:20',
        'posisi' => 'required|string|max:100',
        'tanggal_masuk' => 'nullable|date', // Seharusnya 'required' jika memang wajib
        'gaji_pokok' => 'nullable|numeric|min:0', // Seharusnya 'required' jika memang wajib
    ]);

    // 1. Update data User terkait
    $user = $karyawan->user;
    if ($user) {
        $userDataToUpdate = [
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
        ];
        // Hanya update password jika diisi
        if (!empty($validatedData['password'])) {
            $userDataToUpdate['password'] = Hash::make($validatedData['password']);
        }
        $user->update($userDataToUpdate);
    }

    // 2. Update data Karyawan
    $karyawanDataToUpdate = [
        'nik' => $validatedData['nik'],
        'alamat' => $validatedData['alamat'],
        'no_telepon' => $validatedData['no_telepon'],
        'posisi' => $validatedData['posisi'],
        'tanggal_masuk' => $validatedData['tanggal_masuk'],
        'gaji_pokok' => $validatedData['gaji_pokok'],
    ];
    $karyawan->update($karyawanDataToUpdate);

    return redirect()->route('admin.karyawan.index')
                     ->with('success', 'Data karyawan berhasil diperbarui.');
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Karyawan $karyawan)
{
    try {
        $user = $karyawan->user;
        $karyawan->delete();
        if ($user) {
            $user->delete();
        }

        return redirect()->route('admin.karyawan.index')
                         ->with('success', 'Karyawan berhasil dihapus.');

    } catch (\Exception $e) {
        return redirect()->route('admin.karyawan.index')
                         ->with('error', 'Gagal menghapus karyawan. Error: ' . $e->getMessage());
    }
}
}
