<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FlightController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\AirlineController;
use App\Http\Controllers\PassengerController;

Route::middleware('isGuest')->group(function () {});

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

Route::post('/signup', [UserController::class, 'register'])->name('signup.register');
Route::post('/auth/login', [UserController::class, 'authentication'])->name('auth');
Route::get('/auth/logout', [UserController::class, 'logout'])->name('logout');

Route::middleware('isAdmin')->prefix('/admin')->name('admin.')->group(function () {
    // admin dashboard disimpan di grup middleware tersebut
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');
    // CRUD Resource Routes untuk Airlines
    Route::resource('airlines', AirlineController::class);

    // SoftDelete Routes tambahan (untuk Restore dan Force Delete)
    Route::post('airlines/{id}/restore', [AirlineController::class, 'restore'])->name('airlines.restore');
    Route::delete('airlines/{id}/forceDelete', [AirlineController::class, 'forceDelete'])->name('airlines.forceDelete');
    // CRUD Resource Routes untuk Passengers
    Route::get('/passengers', [PassengerController::class, 'index'])->name('index');
    Route::get('/passengers/create', [PassengerController::class, 'create'])->name('create');
    Route::post('/passengers', [PassengerController::class, 'store'])->name('store');
    Route::get('/passengers/{passenger}/edit', [PassengerController::class, 'edit'])->name('edit');
    Route::put('/passengers/{passenger}', [PassengerController::class, 'update'])->name('update');
    Route::delete('/passengers/{passenger}', [PassengerController::class, 'destroy'])->name('destroy'); // Soft Delete

    Route::get('/trash', [PassengerController::class, 'trash'])->name('trash');
    Route::post('/trash/restore/{id}', [PassengerController::class, 'restore'])->name('restore');
    Route::delete('/trash/delete-permanen/{id}', [PassengerController::class, 'deletePermanen'])->name('delete-permanen');
});

// Route pencarian (sudah Anda ubah)
Route::post('/flights/search', [FlightController::class, 'search'])->name('flights.search');
Route::post('/flights/search', [FlightController::class, 'search'])->name('flights.search');
Route::get('/flights/payment/{id}', [FlightController::class, 'payment'])->name('flights.payment');
Route::get('/flights/confirm/{id}', [FlightController::class, 'confirm']);
Route::post('/flights/confirm/{id}', [FlightController::class, 'confirm'])->name('flights.confirm');
Route::get('/flights/success/{id}', [FlightController::class, 'success'])->name('flights.success');
Route::get('/flights/results', [FlightController::class, 'results'])->name('flights.results');

// User routes (dashboard + payment confirmation)
Route::middleware('auth')->prefix('user')->name('user.')->group(function () {
    // URL: /user/dashboard
    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');
    Route::get('/bookings', [FlightController::class, 'bookingsHistory'])->name('bookings.history');
    Route::get('/booking/{id}/confirm', [TicketController::class, 'showConfirmPayment'])->name('payment.show');
    Route::post('/booking/{id}/confirm', [UserController::class, 'confirmPayment'])->name('payment.confirm');
    Route::post('/barcode', [TicketController::class, 'createBarcode'])->name('barcode');
    Route::get('/payment/proof/{fileName}', [UserController::class, 'getPaymentProof'])->name('payment.proof');
    Route::get('/flights/{id}/details', [FlightController::class, 'showDetails'])->name('flights.details');
});
