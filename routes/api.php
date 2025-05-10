<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController; // ✅ Add this line

// API routes for User management
Route::apiResource('users', UserController::class);

// API routes for Role management
Route::apiResource('roles', RoleController::class);

// API routes for Document management
Route::apiResource('documents', DocumentController::class);

// API routes for Reservation management
Route::apiResource('reservations', ReservationController::class);

// API Registration Route
Route::post('register', [RegisterController::class, 'register'])->name('api.register');

// ✅ API Login Route
Route::post('login', [LoginController::class, 'login'])->name('api.login');

// ✅ Protected routes (e.g., logout)
Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [UserController::class, 'logout'])->name('api.logout');
});
