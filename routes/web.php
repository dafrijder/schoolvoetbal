<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TeamController;
use App\Http\Middleware\AdminMiddleware; // toegevoegd
use Illuminate\Support\Facades\Auth;

// Registratie
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// Login / Logout
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

//team routes
Route::get('/teams', [TeamController::class, 'index'])->name('teams.index');

// Beveiligde pagina (alleen voor ingelogde gebruikers)
Route::get('/home', function () {
    return "Welkom bij de app!";
})->middleware('auth')->name('home');

Route::middleware('auth', 'admin')->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
    // Voeg hier meer admin-specifieke routes toe
});
