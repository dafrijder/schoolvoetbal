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

            Game::create([
                'home_team_id' => $home,
                'away_team_id' => $away,
                'score' => $faker->boolean(70) ? $faker->numberBetween(0, 5) . '-' . $faker->numberBetween(0, 5) : null,
                'referee_id' => $faker->randomElement($referees),
            ]);
        }
    }
}
