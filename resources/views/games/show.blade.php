<h1>Game: {{ $game->id }}</h1>

<p><strong>Thuis:</strong> {{ optional($game->team1)->name ?? $game->team1_id }}</p>
<p><strong>Uit:</strong> {{ optional($game->team2)->name ?? $game->team2_id }}</p>
<p><strong>Score:</strong> {{ $game->team1_score ?? 0 }} - {{ $game->team2_score ?? 0 }}</p>
<p><strong>Veld:</strong> {{ $game->field ?? '-' }}</p>
<p><strong>Scheidsrechter ID:</strong> {{ $game->referee_id ?? '-' }}</p>
<p><strong>Tijd:</strong> {{ $game->time ? \Carbon\Carbon::parse($game->time)->format('Y-m-d H:i') : '-' }}</p>

<p>
    <a href="{{ route('games.index') }}">Terug naar games</a>
    @if (Route::has('games.edit'))
        | <a href="{{ route('games.edit', $game->id) }}">Aanpassen</a>
    @endif
    @if (Route::has('games.destroy'))
        | <form action="{{ route('games.destroy', $game->id) }}" method="POST" style="display:inline" onsubmit="return confirm('Weet je zeker dat je dit game wilt verwijderen?');">
            @csrf
            @method('DELETE')
            <button type="submit">Verwijder</button>
        </form>
    @endif
</p>
