<?php

namespace App\Services;

use App\Models\Game;
use App\Models\Team;
use Carbon\Carbon;

class RoundRobinScheduleGenerator
{
    /**
     * Generate a round-robin tournament schedule for teams with score = 0
     * In a round-robin tournament, every team plays against every other team exactly once.
     *
     * @param int|null $startDate Optional start date for games (default: tomorrow at 10:00)
     * @param int $daysBetweenMatches Days between scheduled matches (default: 7)
     * @param string $field Default field for games (default: 'TBD')
     * @return array Generated games with count
     */
    public function generateSchedule($startDate = null, $daysBetweenMatches = 7, $field = 'TBD')
    {
        // Cast to int to ensure proper type
        $daysBetweenMatches = (int) $daysBetweenMatches;

        // Get all teams with score = 0
        $teams = Team::where('points', 0)->get();

        if ($teams->count() < 2) {
            throw new \Exception('Er moeten minstens 2 teams zijn met score = 0 om een schema te genereren.');
        }

        // Use provided start date or default to tomorrow at 10:00
        $matchDate = $startDate
            ? Carbon::parse($startDate)
            : Carbon::tomorrow()->setTime(10, 0);

        $generatedGames = [];

        // Generate all unique combinations of teams
        $teams_array = $teams->toArray();
        $team_count = count($teams_array);

        for ($i = 0; $i < $team_count; $i++) {
            for ($j = $i + 1; $j < $team_count; $j++) {
                $team1 = $teams_array[$i];
                $team2 = $teams_array[$j];

                // Check if game already exists
                $existingGame = Game::where(function ($query) use ($team1, $team2) {
                    $query->where('team1_id', $team1['id'])
                        ->where('team2_id', $team2['id']);
                })->orWhere(function ($query) use ($team1, $team2) {
                    $query->where('team1_id', $team2['id'])
                        ->where('team2_id', $team1['id']);
                })->first();

                // Only create if game doesn't already exist
                if (!$existingGame) {
                    $game = Game::create([
                        'team1_id' => $team1['id'],
                        'team2_id' => $team2['id'],
                        'team1_score' => 0,
                        'team2_score' => 0,
                        'field' => $field,
                        'referee_id' => null,
                        'time' => $matchDate->copy(),
                    ]);

                    $generatedGames[] = $game;

                    // Increment date for next match
                    $matchDate->addDays($daysBetweenMatches);
                }
            }
        }

        return [
            'count' => count($generatedGames),
            'games' => $generatedGames,
            'teams_count' => $team_count,
            'total_matches' => ($team_count * ($team_count - 1)) / 2,
        ];
    }

    /**
     * Delete all games for teams with score = 0 (reset schedule)
     *
     * @return int Number of games deleted
     */
    public function resetSchedule()
    {
        $teams = Team::where('points', 0)->get();

        $team_ids = $teams->pluck('id')->toArray();

        $count = Game::where(function ($query) use ($team_ids) {
            $query->whereIn('team1_id', $team_ids);
        })->orWhere(function ($query) use ($team_ids) {
            $query->whereIn('team2_id', $team_ids);
        })->delete();

        return $count;
    }
}
