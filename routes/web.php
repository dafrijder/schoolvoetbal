<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\DashboardController;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Registratie
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// Login / Logout
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// team routes (index, create, store, show, edit, update, destroy)
Route::get('/teams', [TeamController::class, 'index'])->name('teams.index');
Route::get('/teams/create', [TeamController::class, 'create'])->name('teams.create');
Route::post('/teams', [TeamController::class, 'store'])->name('teams.store');
Route::get('/teams/{team}', [TeamController::class, 'show'])->name('teams.show');
Route::get('/teams/{team}/edit', [TeamController::class, 'edit'])->name('teams.edit');
Route::put('/teams/{team}', [TeamController::class, 'update'])->name('teams.update');
Route::delete('/teams/{team}', [TeamController::class, 'destroy'])->name('teams.destroy');

//api routes
Route::get('/api/teams', [ApiController::class, 'getTeams'])->name('api.teams');
Route::get('/api/users', [ApiController::class, 'getUsers'])->name('api.users');
Route::get('/api/games', [ApiController::class, 'getGames'])->name('api.games');

// Beveiligde pagina (alleen voor ingelogde gebruikers)
Route::get('/home', [DashboardController::class, 'index'])
    ->middleware('auth')
    ->name('home');

Route::middleware('auth', 'admin')->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
    // Voeg hier meer admin-specifieke routes toe
});
