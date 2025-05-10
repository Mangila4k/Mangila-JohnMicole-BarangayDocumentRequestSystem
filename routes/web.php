<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Auth;

// Welcome page or default route
Route::get('/', function () {
    return view('welcome');
});

// Custom Authentication Routes
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login'); // Custom login page
Route::post('login', [LoginController::class, 'login']); // Login form submission
Route::post('logout', [LoginController::class, 'logout'])->name('logout'); // Custom logout route

// Password Reset Routes
Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request'); // Request password reset link
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email'); // Handle email submission for password reset
Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset'); // Show reset password form with token
Route::post('password/reset', [ResetPasswordController::class, 'reset']); // Handle password reset form submission

// Registration Route for Postman or manual call
Route::post('register', [RegisterController::class, 'register'])->name('register');

// Laravel's default registration and password reset routes
Auth::routes(); // Includes GET /register, password reset views, etc.

// User Routes (CRUD actions for users)
Route::resource('users', UserController::class);

// Role Routes (CRUD actions for roles)
Route::resource('roles', RoleController::class);

// Document Routes (CRUD actions for documents)
Route::resource('documents', DocumentController::class);

// Reservation Routes (CRUD actions for reservations)
Route::resource('reservations', ReservationController::class);
