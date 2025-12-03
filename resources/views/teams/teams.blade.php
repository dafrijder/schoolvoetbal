<h1>Teams</h1>

@if (!empty($teams) && count($teams) > 0)
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Naam</th>
                <th>Acties</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($teams as $team)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        @if (Route::has('teams.show'))
                            <a href="{{ route('teams.show', $team->id) }}">{{ $team->name }}</a>
                        @else
                            {{ $team->name }}
                        @endif
                    </td>
                    <td>
                        @if (Route::has('teams.edit'))
                            <a href="{{ route('teams.edit', $team->id) }}">Aanpassen</a>
                        @endif

                        @if (Route::has('teams.destroy'))
                            <form action="{{ route('teams.destroy', $team->id) }}" method="POST" style="display:inline" onsubmit="return confirm('Weet je zeker dat je dit team wilt verwijderen?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit">Verwijder</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@else
    <p>Geen teams gevonden.</p>
@endif
