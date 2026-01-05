<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FlightController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\AirlineController;
use App\Http\Controllers\PassengerController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\PaymentController;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/login', fn() => view('auth.login'))->name('login');
Route::get('/signup', fn() => view('auth.signup'))->name('signup');

Route::post('/signup', [UserController::class, 'register'])->name('signup.register');
Route::post('/auth/login', [UserController::class, 'authentication'])->name('auth');
Route::get('/auth/logout', [UserController::class, 'logout'])->name('logout');

// bagian flight search dan booking

Route::post('/flights/search', [FlightController::class, 'search'])->name('flights.search');
Route::get('/flights/payment/{id}', [PaymentController::class, 'payment'])->name('flight.payment');
Route::post('/flights/confirm/{id}', [BookingController::class, 'confirm'])->name('flight.confirm');
Route::get('/flights/success/{id}', [FlightController::class, 'success'])->name('flight.success');
Route::get('/flights/results', [FlightController::class, 'results'])->name('flight.result');

// bagian user
Route::middleware('auth')->prefix('/user')->name('user.')->group(function () {

    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');
    Route::get('/bookings', [FlightController::class, 'bookingsHistory'])->name('bookings.history');
    
    Route::get('/booking/{id}/confirm', [TicketController::class, 'showConfirmPayment'])->name('payment.show');
    Route::post('/booking/{id}/confirm', [UserController::class, 'confirmPayment'])->name('payment.confirm');
    
    Route::post('/barcode', [TicketController::class, 'createBarcode'])->name('barcode');
    Route::get('/payment/proof/{fileName}', [UserController::class, 'getPaymentProof'])->name('payment.proof');
    Route::get('/flights/{id}/details', [FlightController::class, 'showDetails'])->name('flights.details');
});

// bagian admin
Route::middleware('isAdmin')->prefix('/admin')->name('admin.')->group(function () {

    Route::get('/dashboard', fn() => view('admin.dashboard'))->name('dashboard');

    Route::prefix('/airlines')->name('airlines.')->group(function () {

        Route::get('/trash', [AirlineController::class, 'trash'])->name('trash');
        Route::post('/{id}/restore', [AirlineController::class, 'restore'])->name('restore');
        Route::delete('/{id}/force-delete', [AirlineController::class, 'forceDelete'])->name('forceDelete');

        Route::get('/', [AirlineController::class, 'index'])->name('index');
        Route::get('/create', [AirlineController::class, 'create'])->name('create');
        Route::post('/store', [AirlineController::class, 'store'])->name('store');
        Route::get('/edit/{airline}', [AirlineController::class, 'edit'])->name('edit');
        Route::put('/update/{airline}', [AirlineController::class, 'update'])->name('update');
        Route::delete('/delete/{airline}', [AirlineController::class, 'destroy'])->name('delete');
    });

    Route::prefix('/passengers')->name('passengers.')->group(function () {

        Route::get('/ sh', [PassengerController::class, 'trash'])->name('trash');
        Route::patch('/restore/{id}', [PassengerController::class, 'restore'])->name('restore');
        Route::delete('/delete-permanent/{id}', [PassengerController::class, 'deletePermanen'])->name('deletePermanent');

        Route::get('/', [PassengerController::class, 'index'])->name('index');
        Route::get('/create', [PassengerController::class, 'create'])->name('create');
        Route::post('/store', [PassengerController::class, 'store'])->name('store');
        Route::get('/edit/{passenger}', [PassengerController::class, 'edit'])->name('edit');
        Route::put('/update/{passenger}', [PassengerController::class, 'update'])->name('update');
        Route::delete('/delete/{passenger}', [PassengerController::class, 'destroy'])->name('delete');
    });

    Route::prefix('/flight')->name('flight.')->group(function () {

        Route::get('/', [FlightController::class, 'index'])->name('index');
        Route::get('/create', [FlightController::class, 'create'])->name('create');
        Route::post('/store', [FlightController::class, 'store'])->name('store');
        Route::get('/edit/{flight}', [FlightController::class, 'edit'])->name('edit');
        Route::put('/update/{flight}', [FlightController::class, 'update'])->name('update');
        Route::delete('/delete/{flight}', [FlightController::class, 'destroy'])->name('delete');
    });
});

