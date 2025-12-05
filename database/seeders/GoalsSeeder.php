<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Goal;
use App\Models\Game;
use App\Models\User;
use Faker\Factory as Faker;

class GoalsSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();
        $games = Game::pluck('id')->all();
        $players = User::pluck('id')->all();

        if (empty($games) || empty($players)) {
            return;
        }

        for ($i = 0; $i < 50; $i++) {
            Goal::create([
                'game_id' => $faker->randomElement($games),
                'player_id' => $faker->randomElement($players),
                'minute' => $faker->numberBetween(1, 90),
            ]);
        }
    }
}
