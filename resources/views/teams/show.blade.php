<x-base-layout>

    <div class="p-8 max-w-3xl mx-auto">

        <h1 class="text-3xl font-bold text-gray-800 mb-6">
            Team: {{ $team->name }}
        </h1>

        <div class="bg-white shadow-md rounded-xl p-6 space-y-4">

            <div class="flex justify-between">
                <p class="text-gray-600 font-semibold">ID:</p>
                <p class="text-gray-900">{{ $team->id }}</p>
            </div>

            <div class="flex justify-between">
                <p class="text-gray-600 font-semibold">Naam:</p>
                <p class="text-gray-900">{{ $team->name }}</p>
            </div>

            <div class="flex justify-between">
                <p class="text-gray-600 font-semibold">Punten:</p>
                <p class="text-gray-900">{{ $team->points }}</p>
            </div>

            <div class="flex justify-between">
                <p class="text-gray-600 font-semibold">Aangemaakt door:</p>
                <p class="text-gray-900">
                    {{ optional($team->creator)->name ?? 'Onbekend' }}
                </p>
            </div>

            <div class="flex justify-between">
                <p class="text-gray-600 font-semibold">Gemaakt op:</p>
                <p class="text-gray-900">
                    {{ $team->created_at ? $team->created_at->format('Y-m-d H:i') : '-' }}
                </p>
            </div>

        </div>

        {{-- Acties --}}
        <div class="mt-6 flex items-center gap-3">

            <a
                href="{{ route('teams.index') }}"
                class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
                Terug naar teams
            </a>

            @if (Route::has('teams.edit'))
                <a
                    href="{{ route('teams.edit', $team->id) }}"
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    Aanpassen
                </a>
            @endif

            @if (Route::has('teams.destroy'))
                <form
                    action="{{ route('teams.destroy', $team->id) }}"
                    method="POST"
                    onsubmit="return confirm('Weet je zeker dat je dit team wilt verwijderen?');"
                >
                    @csrf
                    @method('DELETE')

                    <button
                        type="submit"
                        class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                        Verwijderen
                    </button>
                </form>
            @endif

        </div>

    </div>

</x-base-layout>
