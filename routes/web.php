<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Karyawan\DashboardController as KaryawanDashboardController;
use App\Http\Controllers\Karyawan\AbsensiController as KaryawanAbsensiController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\KaryawanController as AdminKaryawanController;
use App\Http\Controllers\Admin\AbsensiController as AdminAbsensiController;
use App\Http\Controllers\Admin\GajiController as AdminGajiController;

Route::get('/', function () {
    // Jika sudah login, arahkan ke dashboard masing-masing
    if (Auth::check()) {
        if (Auth::user()->role == 'admin') return redirect()->route('admin.dashboard');
        if (Auth::user()->role == 'karyawan') return redirect()->route('karyawan.dashboard');
    }
    return view('auth.login'); // Atau view('auth.login') jika ingin langsung ke login
})->name('home');

// Guest Routes (Hanya bisa diakses jika belum login)
Route::middleware('guest')->group(function () {
    Route::get('register', [RegisterController::class, 'create'])->name('register');
    Route::post('register', [RegisterController::class, 'store']);
    Route::get('login', [LoginController::class, 'create'])->name('login');
    Route::post('login', [LoginController::class, 'store']);
});

// Authenticated Routes
Route::middleware('auth')->group(function () {
    Route::post('logout', [LoginController::class, 'destroy'])->name('logout');
});

Route::middleware(['auth'])->prefix('karyawan')->name('karyawan.')->group(function () {
    Route::get('dashboard', [KaryawanDashboardController::class, 'index'])->name('dashboard');
    Route::post('absensi/masuk', [KaryawanAbsensiController::class, 'clockIn'])->name('absensi.clockin');
    Route::post('absensi/pulang', [KaryawanAbsensiController::class, 'clockOut'])->name('absensi.clockout');
    Route::get('absensi/riwayat', [KaryawanAbsensiController::class, 'riwayat'])->name('absensi.riwayat');
    // Route untuk melengkapi profil karyawan jika diperlukan
    Route::get('profile/complete', [KaryawanDashboardController::class, 'completeProfileForm'])->name('profile.complete.form'); // Ganti controllernya jika beda
    Route::post('profile/complete', [KaryawanDashboardController::class, 'saveCompleteProfile'])->name('profile.complete.save');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('karyawan', AdminKaryawanController::class);
    Route::get('absensi', [AdminAbsensiController::class, 'index'])->name('absensi.index');
    Route::get('gaji', [AdminGajiController::class, 'index'])->name('gaji.index');
    Route::post('gaji/hitung', [AdminGajiController::class, 'hitungDanSimpan'])->name('gaji.hitung');
    Route::get('gaji/cetak/{id}', [AdminGajiController::class, 'cetak'])->name('gaji.cetak');
    Route::delete('gaji/clear', [AdminGajiController::class, 'clear'])->name('gaji.clear');
});