<?php

use App\Http\Controllers\Api\v1\CasasController;
use App\Http\Controllers\Api\v1\TestimonioController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Services\OlimpiadaService;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->group(function () {
    Route::get('/testimonios', [TestimonioController::class, 'index']);
    Route::resource('casas.testimonios', CasasController::class)
        ->only('show')
        ->parameters(['casa_id' => 'casa_id']);;
    Route::post('/testimonios', [TestimonioController::class, 'store']);
});

