<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Goal;
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

    // API /API/MATCHES.PHP
    public function matches()
    {
        $games = Game::with(['team1', 'team2'])->get();
        $data = $games->map(function ($g) {
            return [
                'id' => $g->id,
                'team1_id' => $g->home_team_id,
                'team1_name' => $g->team1?->name,
                'team2_id' => $g->away_team_id,
                'team2_name' => $g->team2?->name,
            ];
        });

        return response()->json($data);
    }

    // API /API/RESULTS.PHP
    public function results()
    {
        $games = Game::with(['team1', 'team2', 'goals.player'])->get();

        $data = $games->map(function ($g) {
            $team1Score = 0;
            $team2Score = 0;

            foreach ($g->goals as $goal) {
                if ($goal->player && $goal->player->team_id == $g->home_team_id) {
                    $team1Score++;
                } elseif ($goal->player && $goal->player->team_id == $g->away_team_id) {
                    $team2Score++;
                }
            }

            // fallback to stored score string if no goals recorded
            if ($team1Score === 0 && $team2Score === 0 && $g->score) {
                [$a, $b] = array_map('intval', explode('-', $g->score));
                $team1Score = $a;
                $team2Score = $b;
            }

            $winner = null;
            if ($team1Score > $team2Score) {
                $winner = $g->home_team_id;
            } elseif ($team2Score > $team1Score) {
                $winner = $g->away_team_id;
            }

            return [
                'id' => $g->id,
                'team1_id' => $g->home_team_id,
                'team1_name' => $g->team1?->name,
                'team1_score' => $team1Score,
                'team2_id' => $g->away_team_id,
                'team2_name' => $g->team2?->name,
                'team2_score' => $team2Score,
                'winner_id' => $winner,
            ];
        });

        return response()->json($data);
    }

    // API /API/GOALS.PHP?MATCH_ID={id}
    public function goals(Request $request)
    {
        $matchId = $request->query('MATCH_ID') ?? $request->query('match_id');
        if (! $matchId) {
            return response()->json(['message' => 'MATCH_ID is required'], 400);
        }

        $goals = Goal::with('player.team')
            ->where('game_id', $matchId)
            ->orderBy('minute')
            ->get();

        $data = $goals->map(function ($g) {
            return [
                'id' => $g->id,
                'match_id' => $g->game_id,
                'minute' => $g->minute,
                'player_id' => $g->player_id,
                'player_team' => $g->player?->team_id,
                'player_name' => $g->player?->name,
            ];
        });

        return response()->json($data);
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
