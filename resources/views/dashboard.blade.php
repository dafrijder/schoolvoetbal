<x-base-layout>
    <div class="p-8 bg-gray-100 min-h-screen">

        <!-- Header -->
        {{-- <div class="mb-8">
            <h1 class="text-4xl font-bold text-gray-800">Dashboard</h1>
            <p class="text-gray-600 mt-2">Welkom op uw dashboard!</p>
        </div> --}}

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
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Datum</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Teams</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Veld</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($games as $game)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 text-sm text-gray-700">
                                    {{ $game->time ? \Carbon\Carbon::parse($game->time)->format('Y-m-d') : '-' }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-900">
                                    {{ optional($game->team1)->name ?? ($game->team1_id ?? '-') }}
                                    &nbsp;vs&nbsp;
                                    {{ optional($game->team2)->name ?? ($game->team2_id ?? '-') }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-700">
                                    {{ $game->field ?? '-' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-6 py-4 text-center text-gray-600">Geen wedstrijden gevonden.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-base-layout>
