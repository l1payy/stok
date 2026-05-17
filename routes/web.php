<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ObatController;
use App\Http\Controllers\TransaksiMasukController;
use App\Http\Controllers\TransaksiKeluarController;
use App\Http\Controllers\LaporanController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    Route::resource('/obat', ObatController::class);
    
    Route::resource('/transaksi-masuk', TransaksiMasukController::class)->only(['index', 'store', 'update', 'destroy']);
    Route::resource('/transaksi-keluar', TransaksiKeluarController::class)->only(['index', 'store', 'update', 'destroy']);
    
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/export', [LaporanController::class, 'export'])->name('laporan.export');

    Route::get('/change-password', function () {
        return view('auth.change-password');
    })->name('password.change');
    
    Route::put('/password', [App\Http\Controllers\Auth\PasswordController::class, 'update'])->name('password.update');
});

require __DIR__.'/auth.php';
