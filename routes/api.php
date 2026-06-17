<?php

use App\Http\Controllers\TestimonioController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {

    Route::get('testimonios', [TestimonioController::class, 'index']);

    Route::get('casas/{casa}/testimonios', [TestimonioController::class, 'testimonios']);

    Route::post('testimonios', [TestimonioController::class, 'store'])->middleware('auth:sanctum');

    Route::put('testimonios/{testimonio}', [TestimonioController::class, 'update'])->middleware('auth:sanctum');

    Route::delete('testimonios/{testimonio}', [TestimonioController::class, 'destroy'])->middleware('auth:sanctum');

    Route::put('testimonios/{testimonio}/approve', [TestimonioController::class, 'approve'])
    ->middleware('auth:sanctum');



});
