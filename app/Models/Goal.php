<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Goal extends Model
{
    protected $fillable = ['player_id', 'game_id', 'minute'];

    public function player()
    {
        return $this->belongsTo(User::class, 'player_id');
    }

    public function Game()
    {
        return $this->belongsTo(Game::class);
    }
}
