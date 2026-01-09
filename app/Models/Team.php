<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $fillable = ['name', 'points', 'creator_id'];

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function players()
    {
        return $this->hasMany(User::class);
    }

    public function GamesAsTeam1()
    {
        return $this->hasMany(Game::class, 'team1_id');
    }

    public function GamesAsTeam2()
    {
        return $this->hasMany(Game::class, 'team2_id');
    }

    public static function recalculatePoints(): void
    {
        // reset all points
        static::query()->update(['points' => 0]);

        $games = Game::whereNotNull('team1_score')
            ->whereNotNull('team2_score')
            ->get();

        foreach ($games as $game) {
            if ($game->team1_score > $game->team2_score) {
                static::where('id', $game->team1_id)->increment('points', 3);
            } elseif ($game->team1_score < $game->team2_score) {
                static::where('id', $game->team2_id)->increment('points', 3);
            } else {
                static::where('id', $game->team1_id)->increment('points', 1);
                static::where('id', $game->team2_id)->increment('points', 1);
            }
        }
    }
}

