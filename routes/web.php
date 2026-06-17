<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\TestimonioController;

Route::get('/', [BookingController::class, 'index'])->name('home');

Route::get('/casa/{id}', [BookingController::class, 'show'])->name('casas.show');

Route::get('/booking/create/{id}', [BookingController::class, 'create'])->name('bookings.create');
Route::post('/booking/store', [BookingController::class, 'store'])->name('bookings.store');

Route::get('/booking/payment/{id}', [BookingController::class, 'payment'])->name('bookings.payment');
Route::post('/booking/payment/{id}', [BookingController::class, 'processPayment'])->name('bookings.process_payment');

Route::get('/booking/success/{id}', [BookingController::class, 'success'])->name('bookings.success');

Route::get('/history', [BookingController::class, 'history'])->name('bookings.history');

Route::delete('/booking/delete/{id}', [BookingController::class, 'destroy'])->name('bookings.destroy');

Route::get('/buscar-casa', [BookingController::class, 'search'])->name('casas.index');

Route::resource('/testimonios', TestimonioController::class);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
