<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DocumentRequestController;

// Public API Routes
Route::post('/register', [RegisterController::class, 'register'])->name('api.register');
Route::post('/login', [LoginController::class, 'login'])->name('api.login');

// Protected API Routes (require authentication via Sanctum)
Route::middleware('auth:sanctum')->group(function () {

    // Logout
    Route::post('/logout', [UserController::class, 'logout'])->name('api.logout');

    // User management
    Route::apiResource('/users', UserController::class);

    // Assign role to user (custom)
    Route::post('/users/{id}/assign-role', [UserController::class, 'assignRole'])
        ->name('users.assignRole');

    // Role management
    Route::apiResource('/roles', RoleController::class);

    // Document management
    Route::apiResource('/documents', DocumentController::class);

    // Reservation management
    Route::apiResource('/reservations', ReservationController::class);

    // Custom approve reservation route
    Route::post('/reservations/{id}/approve', [ReservationController::class, 'approve'])
        ->name('reservations.approve');

    // Document request management
    Route::apiResource('/document-requests', DocumentRequestController::class);

    // Approve document request (custom action)
    Route::post('/document-requests/{id}/approve', [DocumentRequestController::class, 'approve'])
        ->name('document-requests.approve');
});
