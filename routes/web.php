<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookingController;

// Halaman Depan (Home)
Route::get('/', [BookingController::class, 'index'])->name('home');

// Detail Casa
Route::get('/casa/{id}', [BookingController::class, 'show'])->name('casas.show');

// Proses Booking
Route::get('/booking/create/{id}', [BookingController::class, 'create'])->name('bookings.create');
Route::post('/booking/store', [BookingController::class, 'store'])->name('bookings.store');

// Proses Pembayaran
Route::get('/booking/payment/{id}', [BookingController::class, 'payment'])->name('bookings.payment');
Route::post('/booking/payment/{id}', [BookingController::class, 'processPayment'])->name('bookings.process_payment');

// Halaman Sukses (NEW)
Route::get('/booking/success/{id}', [BookingController::class, 'success'])->name('bookings.success');

// Riwayat
Route::get('/history', [BookingController::class, 'history'])->name('bookings.history');
// Hapus Booking
Route::delete('/booking/delete/{id}', [BookingController::class, 'destroy'])->name('bookings.destroy');

// Halaman Pencarian Semua Casa
Route::get('/cari-casa', [BookingController::class, 'search'])->name('casas.index');
