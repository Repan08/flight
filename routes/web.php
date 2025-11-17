<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::middleware('isGuest')->group(function () {
});

Route::get('/', function () {
    return view('home');
})->name('home');

// hanya user yang belum login (guest) bisa akses signup & login
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/signup', function () {
    return view('auth.signup');
})->name('signup');

Route::post('/auth/signup', [UserController::class, 'register'])->name('signup.send_data');
Route::post('/auth/login', [UserController::class, 'authentication'])->name('auth');
Route::get('/auth/logout', [UserController::class, 'logout'])->name('logout');

Route::middleware('isAdmin')->prefix('/admin')->name('admin.')->group(function () {
    // admin dashboard disimpan di grup middleware tersebut
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');
});