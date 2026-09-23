<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CobaController;
use App\Http\Controllers\DataController;
use App\Http\Controllers\MahasiswaController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', function () {
    return view('home');
});

Route::get('hello', function () {
    return 'Hello, Fariza Novianti';
});

Route::get('/coba', [CobaController::class, 'index']);
Route::get('/final', [CobaController::class, 'index2']);

Route::get('/user/{name}', function ($name) {
    return "Nama saya $name";
});

Route::get('/greet/{name?}', function ($name = 'Guest') {
    return "Halo, $name";
});

Route::get('/about', function () {
    return view('about', ['name' => 'Fariza Novianti']);
});

Route::get('/profile/{name?}', function ($name = 'Guest') {
    return view('about', ['name' => $name]);
});

Route::get('/form', [DataController::class, 'form']);
Route::post('/proses', [DataController::class, 'proses'])->name('form.submit');

Route::get('/form-mahasiswa', [MahasiswaController::class, 'formmhs']);
Route::post('/proses-mahasiswa', [MahasiswaController::class, 'prosesmhs'])->name('mahasiswa.proses');