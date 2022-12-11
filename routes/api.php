<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProdukController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    Route::get('/user', [AuthController::class, 'user']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // Produk
    Route::get('/produks', [ProdukController::class, 'index']);
    Route::post('/produks', [ProdukController::class, 'store']);
    Route::get('/produks/{id}', [ProdukController::class, 'show']);
    Route::put('/produks/{id}', [ProdukController::class, 'update']);
    Route::delete('/produks/{id}', [ProdukController::class, 'destroy']);
});