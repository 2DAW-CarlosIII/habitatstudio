<?php

use App\Http\Controllers\API\TestimonioController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->group(function () {
    Route::apiResource('testimonios', TestimonioController::class);
    Route::get('/casas/{casa}/testimonios', [TestimonioController::class, 'testimoniosAprobados']);
    Route::apiResource('testimonios', TestimonioController::class, 'POST')
});
