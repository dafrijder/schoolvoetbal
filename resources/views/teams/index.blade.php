<x-base-layout>

    <div class="p-8">

        <a href="{{ route('teams.create') }}" class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition mb-4 inline-block">Create</a>

        <h1 class="text-3xl font-bold text-gray-800 mb-6">Teams</h1>

        @if (!empty($teams) && count($teams) > 0)

            <div class="overflow-x-auto bg-white shadow rounded-xl">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">#</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Punten</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Naam</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Acties</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-200">

                        @foreach ($teams as $team)
                            <tr class="hover:bg-gray-50 transition">

                                <td class="px-6 py-4 text-gray-700">
                                    {{ $loop->iteration }}
                                </td>

                                <td class="px-6 py-4 text-gray-900 font-semibold">
                                    {{ $team->points ?? 0 }}
                                </td>

                                <td class="px-6 py-4 text-blue-600 font-medium">
                                    @if (Route::has('teams.show'))
                                        <a href="{{ route('teams.show', $team->id) }}" class="hover:underline">
                                            {{ $team->name }}
                                        </a>
                                    @else
                                        {{ $team->name }}
                                    @endif
                                </td>

                                <td class="px-6 py-4 flex items-center gap-3">

                                    @if (Route::has('teams.edit'))
                                        <a href="{{ route('teams.edit', $team->id) }}"
                                           class="px-3 py-1 bg-blue-500 text-white rounded-lg text-sm hover:bg-blue-600">
                                            Aanpassen
                                        </a>
                                    @endif

                                    @if (Route::has('teams.destroy'))
                                        <form action="{{ route('teams.destroy', $team->id) }}" method="POST"
                                              onsubmit="return confirm('Weet je zeker dat je dit team wilt verwijderen?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="px-3 py-1 bg-red-500 text-white rounded-lg text-sm hover:bg-red-600">
                                                Verwijder
                                            </button>
                                        </form>
                                    @endif

                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>

        @else

            <p class="text-gray-600 text-lg">Geen teams gevonden.</p>

        @endif

    </div>

</x-base-layout>
