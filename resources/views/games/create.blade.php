<h1>Nieuw game aanmaken</h1>

@if ($errors->any())
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif

<form method="POST" action="{{ route('games.store') }}">
    @csrf

    <div>
        <label for="team1_id">Thuis team (ID)</label>
        <input type="number" id="team1_id" name="team1_id" value="{{ old('team1_id') }}">
    </div>

    <div>
        <label for="team2_id">Uit team (ID)</label>
        <input type="number" id="team2_id" name="team2_id" value="{{ old('team2_id') }}">
    </div>

    <div>
        <label for="team1_score">Thuis score</label>
        <input type="number" id="team1_score" name="team1_score" value="{{ old('team1_score', 0) }}" min="0">
    </div>

    <div>
        <label for="team2_score">Uit score</label>
        <input type="number" id="team2_score" name="team2_score" value="{{ old('team2_score', 0) }}" min="0">
    </div>

    <div>
        <label for="field">Veld</label>
        <input type="text" id="field" name="field" value="{{ old('field') }}">
    </div>

    <div>
        <label for="referee_id">Scheidsrechter (ID)</label>
        <input type="number" id="referee_id" name="referee_id" value="{{ old('referee_id') }}">
    </div>

    <div>
        <label for="time">Tijd</label>
        <input type="datetime-local" id="time" name="time" value="{{ old('time') }}">
    </div>

    <button type="submit">Aanmaken</button>
    <a href="{{ route('games.index') }}">Annuleren</a>
</form>
