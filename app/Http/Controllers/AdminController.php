<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\RoundRobinScheduleGenerator;
use App\Models\Team;
use App\Models\Game;

class AdminController extends Controller
{
    protected $scheduleGenerator;

    public function __construct(RoundRobinScheduleGenerator $scheduleGenerator)
    {
        $this->scheduleGenerator = $scheduleGenerator;
    }

    public function index(Request $request)
    {
        // Get teams with score = 0
        $teamsWithoutGames = Team::where('points', 0)->get();

        // Get existing games for teams with score = 0
        $team_ids = $teamsWithoutGames->pluck('id')->toArray();
        $existingGames = Game::where(function ($query) use ($team_ids) {
            $query->whereIn('team1_id', $team_ids);
        })->orWhere(function ($query) use ($team_ids) {
            $query->whereIn('team2_id', $team_ids);
        })->count();

        return view('admin.index', [
            'teamsCount' => $teamsWithoutGames->count(),
            'teams' => $teamsWithoutGames,
            'totalPossibleMatches' => $teamsWithoutGames->count() > 1 ?
                ($teamsWithoutGames->count() * ($teamsWithoutGames->count() - 1)) / 2 : 0,
            'existingGamesCount' => $existingGames,
        ]);
    }

    /**
     * Generate round-robin schedule for teams with score = 0
     */
    public function generateSchedule(Request $request)
    {
        try {
            $validated = $request->validate([
                'start_date' => 'nullable|date',
                'days_between' => 'nullable|integer|min:1|max:30',
                'field' => 'nullable|string|max:255',
            ]);

            $startDate = $validated['start_date'] ?? null;
            $daysBetween = $validated['days_between'] ?? 7;
            $field = $validated['field'] ?? 'TBD';

            $result = $this->scheduleGenerator->generateSchedule($startDate, $daysBetween, $field);

            return back()->with('success',
                "Schema gegenereerd! {$result['count']} wedstrijden aangemaakt van {$result['total_matches']} totaal mogelijk.");
        } catch (\Exception $e) {
            return back()->with('error', 'Fout bij het genereren van het schema: ' . $e->getMessage());
        }
    }

    /**
     * Reset/delete all games for teams with score = 0
     */
    public function resetSchedule(Request $request)
    {
        try {
            $count = $this->scheduleGenerator->resetSchedule();
            return back()->with('success', "{$count} wedstrijden verwijderd.");
        } catch (\Exception $e) {
            return back()->with('error', 'Fout bij het resetten van het schema: ' . $e->getMessage());
        }
    }
}
