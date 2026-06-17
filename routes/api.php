<?php

use App\Http\Controllers\API\TestimonioController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('testimonios', TestimonioController::class)->only('index');

Route::apiResource('casas.testimonios', TestimonioController::class);
