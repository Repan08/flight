<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/auth/logout', [UserController::class, 'logout'])->name('logout');

Route::middleware('isGuest')->group(function () {
    // hanya user yang belum login (guest) bisa akses signup & login
    Route::get('/auth/login', function () {
        return view('auth.login');
    })->name('login');

    Route::get('/auth/signup', function () {
        return view('auth.signup');
    })->name('signup');

    Route::post('/auth/signup', [UserController::class, 'register'])->name('signup.send_data');
    Route::post('/auth/login', [UserController::class, 'authentication'])->name('auth');
});