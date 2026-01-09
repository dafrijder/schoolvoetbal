<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Game;
use App\Models\Team;
use App\Models\User;
use Faker\Factory as Faker;

class GamesSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();
        $teams = Team::pluck('id')->all();
        $referees = User::pluck('id')->all();

        if (count($teams) < 2 || empty($referees)) {
            return;
        }

        for ($i = 0; $i < 20; $i++) {
            $home = $faker->randomElement($teams);
            do {
                $away = $faker->randomElement($teams);
            } while ($away === $home);

            $team1Score = null;
            $team2Score = null;
            if ($faker->boolean(70)) {
                $team1Score = $faker->numberBetween(0, 5);
                $team2Score = $faker->numberBetween(0, 5);
            }

            Game::create(array_filter([
                'team1_id' => $home,
                'team2_id' => $away,
                'team1_score' => $team1Score,
                'team2_score' => $team2Score,
                'referee_id' => $faker->randomElement($referees),
            ], function ($v) { return !is_null($v); }));
        }
    }
}
