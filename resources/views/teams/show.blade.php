<h1>Team: {{ $team->name }}</h1>


<p><strong>ID:</strong> {{ $team->id }}</p>
<p><strong>Naam:</strong> {{ $team->name }}</p>
<p><strong>Punten:</strong> {{ $team->points }}</p>
<p><strong>Aangemaakt door:</strong> {{ optional($team->creator)->name ?? 'Onbekend' }}</p>
<p><strong>Gemaakt:</strong> {{ $team->created_at ? $team->created_at->format('Y-m-d H:i') : '-' }}</p>

<p>
    <a href="{{ route('teams.index') }}">Terug naar teams</a>
    @if (Route::has('teams.edit'))
        | <a href="{{ route('teams.edit', $team->id) }}">Aanpassen</a>
    @endif
    @if (Route::has('teams.destroy'))
        | <form action="{{ route('teams.destroy', $team->id) }}" method="POST" style="display:inline" onsubmit="return confirm('Weet je zeker dat je dit team wilt verwijderen?');">
            @csrf
            @method('DELETE')
            <button type="submit">Verwijder</button>
        </form>
    @endif
</p>
<div>
    <!-- Live as if you were to die tomorrow. Learn as if you were to live forever. - Mahatma Gandhi -->
</div>
