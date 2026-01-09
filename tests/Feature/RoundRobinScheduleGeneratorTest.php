<?php

namespace Tests\Feature;

use App\Models\Team;
use App\Models\User;
use App\Models\Game;
use App\Services\RoundRobinScheduleGenerator;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoundRobinScheduleGeneratorTest extends TestCase
{
    use RefreshDatabase;

    protected $scheduleGenerator;

    protected function setUp(): void
    {
        parent::setUp();
        $this->scheduleGenerator = new RoundRobinScheduleGenerator();
    }

    /**
     * Test that schedule generator creates correct number of matches
     * For 4 teams: (4 * 3) / 2 = 6 matches
     */
    public function test_generates_correct_number_of_matches()
    {
        // Create an admin user
        $admin = User::factory()->create(['is_admin' => true]);

        // Create 4 teams with score 0
        for ($i = 1; $i <= 4; $i++) {
            Team::factory()->create([
                'points' => 0,
                'creator_id' => $admin->id,
                'name' => "Team $i"
            ]);
        }

        $result = $this->scheduleGenerator->generateSchedule();

        $this->assertEquals(6, $result['count']);
        $this->assertEquals(6, $result['total_matches']);
        $this->assertEquals(4, $result['teams_count']);
    }

    /**
     * Test that only teams with score 0 are included
     */
    public function test_only_includes_teams_with_zero_points()
    {
        $admin = User::factory()->create(['is_admin' => true]);

        // Create teams with score 0
        Team::factory()->create(['points' => 0, 'creator_id' => $admin->id, 'name' => 'Team A']);
        Team::factory()->create(['points' => 0, 'creator_id' => $admin->id, 'name' => 'Team B']);

        // Create teams with score > 0
        Team::factory()->create(['points' => 3, 'creator_id' => $admin->id, 'name' => 'Team C']);
        Team::factory()->create(['points' => 5, 'creator_id' => $admin->id, 'name' => 'Team D']);

        $result = $this->scheduleGenerator->generateSchedule();

        $this->assertEquals(1, $result['count']);
        $this->assertEquals(1, $result['total_matches']);
        $this->assertEquals(2, $result['teams_count']);
    }

    /**
     * Test that reset deletes all games for teams with score 0
     */
    public function test_reset_schedule_deletes_games()
    {
        $admin = User::factory()->create(['is_admin' => true]);

        // Create teams
        $team1 = Team::factory()->create(['points' => 0, 'creator_id' => $admin->id]);
        $team2 = Team::factory()->create(['points' => 0, 'creator_id' => $admin->id]);
        $team3 = Team::factory()->create(['points' => 3, 'creator_id' => $admin->id]);

        // Create games
        Game::create([
            'team1_id' => $team1->id,
            'team2_id' => $team2->id,
        ]);
        Game::create([
            'team1_id' => $team1->id,
            'team2_id' => $team3->id,
        ]);

        $this->assertEquals(2, Game::count());

        $deletedCount = $this->scheduleGenerator->resetSchedule();

        // Should only delete the game between teams with score 0
        $this->assertEquals(1, $deletedCount);
        $this->assertEquals(1, Game::count());
    }

    /**
     * Test that same game is not created twice
     */
    public function test_does_not_duplicate_existing_games()
    {
        $admin = User::factory()->create(['is_admin' => true]);

        $team1 = Team::factory()->create(['points' => 0, 'creator_id' => $admin->id]);
        $team2 = Team::factory()->create(['points' => 0, 'creator_id' => $admin->id]);

        // Create initial game
        Game::create([
            'team1_id' => $team1->id,
            'team2_id' => $team2->id,
        ]);

        // Try to generate schedule again
        $result = $this->scheduleGenerator->generateSchedule();

        // Should not create duplicate
        $this->assertEquals(0, $result['count']);
        $this->assertEquals(1, Game::count());
    }
}
