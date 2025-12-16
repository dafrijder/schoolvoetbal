<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    protected $fillable = [
        'home_team_id', 'away_team_id', 'score',
        // 'home_team_id', 'away_team_id', 'home_team_score', 'away_team_score',
        'field', 'referee_id', 'time'
    ];

    public function team1()
    {
        return $this->belongsTo(Team::class, 'home_team_id');
    }

    public function team2()
    {
        return $this->belongsTo(Team::class, 'away_team_id');
    }

    public function referee()
    {
        return $this->belongsTo(User::class, 'referee_id');
    }

    public function goals()
    {
        return $this->hasMany(Goal::class);
    }
}
