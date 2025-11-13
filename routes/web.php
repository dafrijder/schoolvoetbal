<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Middleware\AdminMiddleware; // toegevoegd
use Illuminate\Support\Facades\Auth;

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

Route::middleware(['auth', AdminMiddleware::class])->group(function () {
    // directe /admin naar dashboard
    Route::get('/admin', function () {
        return redirect('/admin/dashboard');
    });

    Route::get('/admin/dashboard', [AdminController::class, 'index']);
    // voeg andere admin routes toe
});

Route::get('/whoami', function () {
    return [
        'check' => Auth::check(),
        'user' => Auth::user() ? Auth::user()->only(['id','name','email','is_admin']) : null,
    ];
});
