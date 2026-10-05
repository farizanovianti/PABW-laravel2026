<?php

use App\Http\Controllers\LaporanBanjirController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('laporan-banjir.create');
});

Route::controller(LaporanBanjirController::class)
    ->prefix('lapor-banjir')
    ->name('laporan-banjir.')
    ->group(function () {
        Route::get('/', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('/konfirmasi', 'konfirmasi')->name('konfirmasi');
        Route::get('/daftar', 'index')->name('index');
});

