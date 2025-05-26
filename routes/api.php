<?php

use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\TransaksiController;
use Illuminate\Support\Facades\Route;

Route::prefix('products')->group(function () {
  Route::get('/', [ProductController::class, 'index']);
  Route::post('/', [ProductController::class, 'store']);
  Route::get('{id}', [ProductController::class, 'show']);
  Route::put('{id}', [ProductController::class, 'update']);
  Route::delete('{id}', [ProductController::class, 'destroy']);
});

Route::apiResource('transaksis', TransaksiController::class);
Route::post('/transaksis', [TransaksiController::class, 'store']);
