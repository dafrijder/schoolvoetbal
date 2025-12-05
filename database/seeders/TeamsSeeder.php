<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Team;
use App\Models\User;
use Faker\Factory as Faker;

class TeamsSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();
        $creatorId = User::first()?->id ?? 1;

        for ($i = 0; $i < 8; $i++) {
            Team::create([
                'name' => $faker->unique()->company,
                'points' => 0,
                'creator_id' => $creatorId,
            ]);
        }
    }
}
