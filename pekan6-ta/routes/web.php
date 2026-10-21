<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\LaporanBanjirController;
use App\Http\Controllers\PetugasController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('laporan-banjir.create');
});

Route::get('/lapor-banjir', [LaporanBanjirController::class, 'create'])->name('laporan-banjir.create');
Route::post('/lapor-banjir', [LaporanBanjirController::class, 'store'])->name('laporan-banjir.store');
Route::get('/lapor-banjir/konfirmasi', [LaporanBanjirController::class, 'konfirmasi'])->name('laporan-banjir.konfirmasi');

Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisterController::class, 'create'])->name('register');
    Route::post('/register', [RegisterController::class, 'store']);
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store']);
});

Route::post('/logout', [LoginController::class, 'destroy'])->name('logout')->middleware('auth');

Route::middleware('auth')->group(function () {
    Route::get('/lapor-banjir/daftar', [LaporanBanjirController::class, 'index'])->name('laporan-banjir.index');
    Route::get('/profil', [PetugasController::class, 'profile'])->name('profil');
});