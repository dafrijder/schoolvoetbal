<?php

use App\Http\Controllers\ApiController;
use App\Http\Controllers\AuthController;

// Registratie
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// Login / Logout
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Beveiligde pagina (alleen voor ingelogde gebruikers)
Route::get('/home', function () {
    return "Welkom bij de app!";
})->middleware('auth');

// API Routes
Route::get('/api/users', [ApiController::class, 'index']);
Route::get('/api/users/{id}', [ApiController::class, 'show']);
