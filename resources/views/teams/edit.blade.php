<h1>Team aanpassen: {{ $team->name }}</h1>

@if ($errors->any())
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif

<form method="POST" action="{{ route('teams.update', $team->id) }}">
    @csrf
    @method('PUT')

    <div>
        <label for="name">Naam</label>
        <input type="text" name="name" id="name" value="{{ old('name', $team->name) }}">
    </div>

    <div>
        <label for="points">Punten</label>
        <input type="number" name="points" id="points" value="{{ old('points', $team->points) }}">
    </div>

    <button type="submit">Opslaan</button>
    <a href="{{ route('teams.index') }}">Annuleer</a>
</form>
