<?php

use App\Http\Controllers\KontakController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () { 
    return redirect()->route('kontaks.index'); 
}); 

Route::resource('kontaks', KontakController::class); 
