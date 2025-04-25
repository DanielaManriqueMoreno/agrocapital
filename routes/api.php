<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Rutas de API para productos
Route::get('/products/{id}/check-stock', [ProductController::class, 'checkStock']);
Route::post('/products/{id}/calculate-discount', [ProductController::class, 'calculateDiscount']);
