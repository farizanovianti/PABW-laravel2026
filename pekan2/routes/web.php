<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LaporanBanjirController;

Route::get('/', function () {
    return view('welcome');
});

Route::controller(LaporanBanjirController::class)
    ->prefix('lapor-banjir')
    ->name('laporan-banjir.')
    ->group(function () {
        Route::get('/', 'create')->name('create');
        Route::post('/', 'store')->name('store');
});
