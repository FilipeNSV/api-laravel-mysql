<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\TransactionController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::post('register', [AuthController::class, 'register'])->name('auth.register');
    Route::post('login', [AuthController::class, 'login'])->name('auth.login');
});

Route::apiResource('transactions', TransactionController::class);
Route::group(['middleware' => 'apiJwt'], function () {
    Route::get('users/{userId}/transactions', [TransactionController::class, 'getTransactionsByUser']);
    Route::apiResource('products', ProductController::class);
    Route::apiResource('services', ServiceController::class);
});
