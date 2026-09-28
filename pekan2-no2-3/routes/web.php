<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DinasController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrangtuaController;
use Illuminate\Support\Facades\Route;

// publik, redirect ke dashboard kalo sudah login

Route::middleware('guest')->group(function () {
    Route::get('/', [HomeController::class, 'landing'])->name('landing');
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
});

Route::post('/login', [AuthController::class, 'login'])->name('login.attempt');
Route::post('/register', [AuthController::class, 'register'])->name('register.attempt');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// guru

Route::middleware(['role:guru'])->prefix('guru')->name('guru.')->group(function () {
    Route::get('/', fn () => redirect()->route('guru.dashboard'))->name('index');
    Route::get('/dashboard', [GuruController::class, 'dashboard'])->name('dashboard');
    Route::get('/siswa', [GuruController::class, 'siswaIndex'])->name('siswa.index');
    Route::post('/siswa', [GuruController::class, 'siswaStore'])->name('siswa.store');
    Route::get('/siswa/{id}', [GuruController::class, 'siswaShow'])->name('siswa.show');
    Route::post('/siswa/{id}', [GuruController::class, 'siswaUpdate'])->name('siswa.update');
    Route::post('/siswa/{id}/delete', [GuruController::class, 'siswaDestroy'])->name('siswa.destroy');
    Route::post('/log', [GuruController::class, 'logStore'])->name('log.store');
    Route::get('/validasi', [GuruController::class, 'validasiIndex'])->name('validasi');
    Route::post('/validasi', [GuruController::class, 'validasiStore'])->name('validasi.store');
    Route::get('/modul', [GuruController::class, 'modul'])->name('modul');
    Route::get('/pengajuan', [GuruController::class, 'pengajuanIndex'])->name('pengajuan');
    Route::post('/pengajuan', [GuruController::class, 'pengajuanStore'])->name('pengajuan.store');
});

// orang tua (mobile layout)

Route::middleware(['role:orang_tua'])->prefix('orangtua')->name('orangtua.')->group(function () {
    Route::get('/', fn () => redirect()->route('orangtua.dashboard'))->name('index');
    Route::get('/dashboard', [OrangtuaController::class, 'dashboard'])->name('dashboard');
    Route::get('/anak', [OrangtuaController::class, 'anak'])->name('anak');
    Route::get('/jalur', [OrangtuaController::class, 'jalur'])->name('jalur');
    Route::get('/modul', [OrangtuaController::class, 'modul'])->name('modul');
});

// dinas

Route::middleware(['role:dinas'])->prefix('dinas')->name('dinas.')->group(function () {
    Route::get('/', fn () => redirect()->route('dinas.dashboard'))->name('index');
    Route::get('/dashboard', [DinasController::class, 'dashboard'])->name('dashboard');
    Route::get('/siswa', [DinasController::class, 'siswaIndex'])->name('siswa.index');
    Route::get('/siswa/{id}', [DinasController::class, 'siswaShow'])->name('siswa.show');
    Route::get('/pengajuan', [DinasController::class, 'pengajuanIndex'])->name('pengajuan');
    Route::post('/pengajuan/{id}/review', [DinasController::class, 'pengajuanReview'])->name('pengajuan.review');
    Route::get('/pipeline', [DinasController::class, 'pipelineIndex'])->name('pipeline');
    Route::post('/pipeline', [DinasController::class, 'pipelineStore'])->name('pipeline.store');
    Route::post('/pipeline/{id}/update', [DinasController::class, 'pipelineUpdate'])->name('pipeline.update');
    Route::get('/mitra', [DinasController::class, 'mitra'])->name('mitra');
    Route::get('/master', [DinasController::class, 'master'])->name('master');
});

// fallback, dashboard kalo sudah login dan landing kalo belum

Route::fallback(function () {
    $user = session('auth_user');

    if ($user) {
        return redirect()->to(
            $user['role'] === 'orang_tua' ? '/orangtua/dashboard' : '/'.$user['role'].'/dashboard'
        );
    }

    return redirect()->route('landing');
});
