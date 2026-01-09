<nav>
    <ul>
        <li><a href="{{ route('home') }}">Home</a></li>
        <li><a href="{{ route('games.index') }}">Games</a></li>
        <li><a href="{{ route('teams.index') }}">Teams</a></li>
        @if(auth()->user() && auth()->user()->is_admin)
            <li><a href="{{ route('admin.index') }}">Beheer</a></li>
        @endif
    </ul>
</nav>
