<x-base-layout>

    <div class="p-8">

        <a href="{{ route('games.create') }}" class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition mb-4 inline-block">Create</a>

        <h1 class="text-3xl font-bold text-gray-800 mb-6">Games</h1>

        @if (!empty($games) && count($games) > 0)

            <div class="overflow-x-auto bg-white shadow rounded-xl">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">#</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Thuis</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Uit</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Score</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Tijd</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Acties</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-200">

                        @foreach ($games as $game)
                            <tr class="hover:bg-gray-50 transition">

                                <td class="px-6 py-4 text-gray-700">{{ $loop->iteration }}</td>

                                <td class="px-6 py-4 text-gray-900">
                                    {{ optional($game->team1)->name ?? '—' }}
                                </td>

                                <td class="px-6 py-4 text-gray-900">{{ optional($game->team2)->name ?? '—' }}</td>

                                <td class="px-6 py-4 text-gray-700">{{ $game->team1_score ?? 0 }} - {{ $game->team2_score ?? 0 }}</td>

                                <td class="px-6 py-4 text-gray-700">{{ $game->time ? \\Carbon\\Carbon::parse($game->time)->format('Y-m-d H:i') : '-' }}</td>

                                <td class="px-6 py-4 flex items-center gap-3">

                                    @if (Route::has('games.show'))
                                        <a href="{{ route('games.show', $game->id) }}" class="px-3 py-1 bg-gray-200 rounded-lg text-sm">Bekijk</a>
                                    @endif

                                    @if (Route::has('games.edit'))
                                        <a href="{{ route('games.edit', $game->id) }}" class="px-3 py-1 bg-blue-500 text-white rounded-lg text-sm">Aanpassen</a>
                                    @endif

                                    @if (Route::has('games.destroy'))
                                        <form action="{{ route('games.destroy', $game->id) }}" method="POST" onsubmit="return confirm('Weet je zeker?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-3 py-1 bg-red-500 text-white rounded-lg text-sm">Verwijder</button>
                                        </form>
                                    @endif

                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>

        @else

            <p class="text-gray-600 text-lg">Geen games gevonden.</p>

        @endif

    </div>

</x-base-layout>
