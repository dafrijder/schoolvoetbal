<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         $teams = Team::all();
        return view('teams.index', compact('teams'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('teams.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'points' => 'nullable|integer',
        ]);

        $team = new Team();
        $team->name = $validated['name'];
        $team->points = $validated['points'] ?? 0;
        // If you have authentication, use auth()->id(); otherwise leave creator_id null or set to 1
        $team->creator_id = auth()->id() ?? 1;
        $team->save();

        return redirect()->route('teams.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $team = Team::findOrFail($id);
        return view('teams.show', compact('team'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $team = Team::findOrFail($id);
        $user = auth()->user();
        if (! $user || ($team->creator_id !== $user->id && ! ($user->is_admin ?? false))) {
            abort(403, 'Toegang geweigerd');
        }

        return view('teams.edit', compact('team'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $team = Team::findOrFail($id);

        $user = auth()->user();
        if (! $user || ($team->creator_id !== $user->id && ! ($user->is_admin ?? false))) {
            abort(403, 'Toegang geweigerd');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'points' => 'nullable|integer',
        ]);

        $team->name = $validated['name'];
        if (array_key_exists('points', $validated)) {
            $team->points = $validated['points'] ?? 0;
        }
        $team->save();

        return redirect()->route('teams.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $team = Team::findOrFail($id);
        $user = auth()->user();
        if (! $user || ($team->creator_id !== $user->id && ! ($user->is_admin ?? false))) {
            abort(403, 'Toegang geweigerd');
        }

        $team->delete();
        return redirect()->route('teams.index');
    }
}
