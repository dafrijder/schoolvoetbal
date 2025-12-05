<h1>Team aanmaken</h1>

@if ($errors->any())
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif

<form method="POST" action="{{ route('teams.store') }}">
    @csrf

    <div>
        <label for="name">Naam</label>
        <input type="text" id="name" name="name" value="{{ old('name') }}" required>
    </div>

    <div>
        <label for="points">Punten</label>
        <input type="number" id="points" name="points" value="{{ old('points', 0) }}" min="0">
    </div>

    {{-- hidden creator id: set if user is authenticated (optional, controller sets creator_id server-side) --}}
    <input type="hidden" name="creator_id" value="{{ auth()->id() ?? '' }}">

    <button type="submit">Aanmaken</button>
    <a href="{{ route('teams.index') }}">Annuleren</a>
</form>
