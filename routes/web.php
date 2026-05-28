<?php

use App\Http\Controllers\Admin\AbsensiController as AdminAbsensiController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\GuruController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Admin\PengaturanController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Guru\AbsensiController as GuruAbsensiController;
use App\Http\Controllers\Guru\DashboardController as GuruDashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (! auth()->check()) {
        return redirect()->route('login');
    }

    return auth()->user()->isAdmin()
        ? redirect()->route('admin.dashboard')
        : redirect()->route('guru.dashboard');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});

Route::post('/logout', [LoginController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    Route::resource('guru', GuruController::class)->except(['show']);

    Route::get('/absensi', [AdminAbsensiController::class, 'index'])->name('absensi.index');
    Route::post('/absensi', [AdminAbsensiController::class, 'store'])->name('absensi.store');
    Route::get('/absensi/{absensi}/edit', [AdminAbsensiController::class, 'edit'])->name('absensi.edit');
    Route::put('/absensi/{absensi}', [AdminAbsensiController::class, 'update'])->name('absensi.update');

    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/pdf', [LaporanController::class, 'exportPdf'])->name('laporan.pdf');
    Route::get('/laporan/excel', [LaporanController::class, 'exportExcel'])->name('laporan.excel');

    Route::get('/pengaturan', [PengaturanController::class, 'index'])->name('pengaturan.index');
    Route::put('/pengaturan', [PengaturanController::class, 'update'])->name('pengaturan.update');

    Route::get('/izin', [PengaturanController::class, 'izinIndex'])->name('izin.index');
    Route::put('/izin/{pengajuanIzin}', [PengaturanController::class, 'izinUpdate'])->name('izin.update');
});

Route::middleware(['auth', 'role:guru'])->prefix('guru')->name('guru.')->group(function () {
    Route::get('/dashboard', [GuruDashboardController::class, 'index'])->name('dashboard');

    Route::post('/check-in', [GuruAbsensiController::class, 'checkIn'])->name('check-in');
    Route::post('/check-out', [GuruAbsensiController::class, 'checkOut'])->name('check-out');
    Route::get('/riwayat', [GuruAbsensiController::class, 'riwayat'])->name('riwayat');

    Route::get('/izin', [GuruAbsensiController::class, 'izinForm'])->name('izin.form');
    Route::post('/izin', [GuruAbsensiController::class, 'izinStore'])->name('izin.store');
});
