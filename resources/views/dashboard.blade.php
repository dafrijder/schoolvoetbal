<x-base-layout>
    <div class="p-8 bg-gray-100 min-h-screen">

        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-4xl font-bold text-gray-800">Dashboard</h1>
            <p class="text-gray-600 mt-2">Welkom op uw dashboard!</p>
        </div>

        <!-- Statistieken -->
        <h2 class="text-2xl font-semibold text-gray-800 mb-4">Statistieken</h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">

            <div class="bg-white shadow rounded-xl p-6">
                <p class="text-sm text-gray-500">Teams</p>
                <p class="text-3xl font-bold text-blue-600">{{ $teams->count() }}</p>
            </div>

            <div class="bg-white shadow rounded-xl p-6">
                <p class="text-sm text-gray-500">Games</p>
                <p class="text-3xl font-bold text-green-600">{{ $games->count() }}</p>
            </div>

            <div class="bg-white shadow rounded-xl p-6">
                <p class="text-sm text-gray-500">Goals</p>
                <p class="text-3xl font-bold text-red-600">{{ $goals->count() }}</p>
            </div>
        </div>

        <!-- Teams -->
        <h3 class="text-xl font-semibold text-gray-800 mb-2">Teams</h3>
        <div class="bg-white shadow rounded-xl p-5 mb-10">
            <ul class="space-y-2">
                @foreach ($teams as $team)
                    <li class="p-3 bg-gray-50 rounded border border-gray-200">
                        {{ $team->name ?? 'Onbekend team' }}
                    </li>
                @endforeach
            </ul>
        </div>

        <!-- Games -->
        <h3 class="text-xl font-semibold text-gray-800 mb-2">Games</h3>
        <div class="bg-white shadow rounded-xl p-5 mb-10">
            <ul class="space-y-3">
                @foreach ($games as $game)
                    <li class="p-3 bg-gray-50 rounded border border-gray-200">
                        <span class="font-semibold text-gray-700">Game #{{ $game->id }}</span>
                        —
                        {{ $game->home_team_name ?? ($game->homeTeam->name ?? 'Thuis') }}
                        <span class="font-medium text-gray-800">vs</span>
                        {{ $game->away_team_name ?? ($game->awayTeam->name ?? 'Uit') }}
                        @if (isset($game->score))
                            <span class="text-blue-600 font-semibold">(score: {{ $game->score }})</span>
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>

        <!-- Goals -->
        <h3 class="text-xl font-semibold text-gray-800 mb-2">Goals</h3>
        <div class="bg-white shadow rounded-xl p-5">
            <ul class="space-y-3">
                @foreach ($goals as $goal)
                    <li class="p-3 bg-gray-50 rounded border border-gray-200">
                        <span class="font-semibold text-gray-700">Goal #{{ $goal->id }}</span>
                        —
                        {{ $goal->player_name ?? ($goal->player->name ?? 'Speler') }}
                        @if (isset($goal->minute))
                            <span class="text-green-600 font-medium">(min: {{ $goal->minute }})</span>
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>

    </div>


</x-base-layout>
