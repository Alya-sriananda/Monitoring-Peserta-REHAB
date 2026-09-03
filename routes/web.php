<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BatchController;
use App\Http\Controllers\PesertaController;
use App\Http\Controllers\VerifikasiSippController;
use App\Http\Controllers\KomunikasiController;
use App\Http\Controllers\Pengaturan\TemplatePesanController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::resource('batch', BatchController::class)->only(['index', 'store', 'show']);
    
    Route::get('peserta', [PesertaController::class, 'index'])->name('peserta.index');
    Route::get('peserta/{peserta}', [PesertaController::class, 'show'])->name('peserta.show');
    
    Route::post('peserta/{peserta}/verifikasi', [VerifikasiSippController::class, 'store'])->name('verifikasi.store');
    
    Route::post('peserta/{peserta}/komunikasi/generate', [KomunikasiController::class, 'generate'])->name('komunikasi.generate');
    Route::post('peserta/{peserta}/komunikasi', [KomunikasiController::class, 'store'])->name('komunikasi.store');
    
    Route::get('laporan', [\App\Http\Controllers\LaporanController::class, 'index'])->name('laporan.index');
    Route::get('laporan/export', [\App\Http\Controllers\LaporanController::class, 'export'])->name('laporan.export');
    
    Route::resource('pengaturan/template-pesan', TemplatePesanController::class)->except(['create', 'show', 'edit']);
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
