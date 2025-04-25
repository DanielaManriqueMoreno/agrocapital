<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Api\ProductController as ApiProductController;

// Ruta principal - redirige directamente a productos
Route::get('/', function () {
    return redirect()->route('products.index');
})->name('home');

// Rutas de productos
Route::resource('products', ProductController::class);

// Ruta de acerca de
Route::get('/about', function () {
    return view('about');
})->name('about');

// Rutas para las funcionalidades de API (opcional)
Route::get('/product-api/{id}/check-stock', [ApiProductController::class, 'checkStock'])->name('product.check-stock');
Route::post('/product-api/{id}/calculate-discount', [ApiProductController::class, 'calculateDiscount'])->name('product.calculate-discount');

// Añadir estas rutas al final del archivo web.php
Route::get('/api/products/{id}/check-stock', [App\Http\Controllers\Api\ProductController::class, 'checkStock']);
Route::post('/api/products/{id}/calculate-discount', [App\Http\Controllers\Api\ProductController::class, 'calculateDiscount']);

