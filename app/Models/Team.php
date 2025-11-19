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
}

