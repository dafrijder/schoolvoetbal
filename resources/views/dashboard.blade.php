<div>
    <h1>Dashboard</h1>
    <p>Welkom op uw dashboard!</p>

    <h2>Statistieken</h2>
    <ul>
        <li>Teams: {{ $teams->count() }}</li>
        <li>Games: {{ $games->count() }}</li>
        <li>Goals: {{ $goals->count() }}</li>
    </ul>

    <h3>Teams</h3>
    <ul>
        @foreach($teams as $team)
            <li>{{ $team->name ?? 'Onbekend team' }}</li>
        @endforeach
    </ul>

    <h3>Games</h3>
    <ul>
        @foreach($games as $game)
            <li>
                {{ $game->id }}
                —
                {{ $game->home_team_name ?? ($game->homeTeam->name ?? 'Thuis') }}
                vs
                {{ $game->away_team_name ?? ($game->awayTeam->name ?? 'Uit') }}
                {{ isset($game->score) ? " (score: {$game->score})" : '' }}
            </li>
        @endforeach
    </ul>

    <h3>Goals</h3>
    <ul>
        @foreach($goals as $goal)
            <li>
                {{ $goal->id }} —
                {{ $goal->player_name ?? ($goal->player->name ?? 'Speler') }}
                {{ isset($goal->minute) ? " (min: {$goal->minute})" : '' }}
            </li>
        @endforeach
    </ul>
</div>
