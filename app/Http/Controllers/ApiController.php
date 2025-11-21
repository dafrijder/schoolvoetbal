<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function index()
    {
        return response()->json(User::all());
    }

    //users show
    public function getUsers()
    {
        $users = User::all();
        return response()->json($users);
    }
    //teams show
    public function getTeams()
    {
        $teams = Team::all();
        return response()->json($teams);
    }

    //games show
    public function getGames()
    {
        $games = Game::all();
        return response()->json($games);
    }

    public function show($id)
    {
        $user = User::find($id);
        if ($user) {
            return response()->json($user);
        } else {
            return response()->json(['message' => 'User not found'], 404);
        }
    }
}
