<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Goal;
use App\Models\Team;

class DashboardController extends Controller
{
    public function index()
    {
        // haal records op (pas filters/limiet aan indien gewenst)
        $games = Game::latest()->get();
        $goals = Goal::latest()->get();
        $teams = Team::orderBy('name')->get();

        return view('dashboard', compact('games', 'goals', 'teams'));
    }
}
