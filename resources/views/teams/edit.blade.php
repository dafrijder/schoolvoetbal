<x-base-layout>

    <div class="p-8 max-w-xl mx-auto">

        <h1 class="text-3xl font-bold text-gray-800 mb-6">
            Team aanpassen: {{ $team->name }}
        </h1>

        {{-- Validatie errors --}}
        @if ($errors->any())
            <div class="mb-6 bg-red-100 border border-red-300 text-red-700 px-4 py-3 rounded-xl">
                <ul class="list-disc ml-5 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li class="text-sm">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white shadow-md rounded-xl p-6">

            <form method="POST" action="{{ route('teams.update', $team->id) }}" class="space-y-5">
                @csrf
                @method('PUT')

                {{-- Naam --}}
                <div>
                    <label for="name" class="block text-gray-700 font-semibold mb-1">
                        Naam
                    </label>

                    <input
                        type="text"
                        name="name"
                        id="name"
                        value="{{ old('name', $team->name) }}"
                        required
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-400 focus:border-blue-400"
                    >
                </div>

                {{-- Punten --}}
                <div>
                    <label for="points" class="block text-gray-700 font-semibold mb-1">
                        Punten
                    </label>

                    <input
                        type="number"
                        name="points"
                        id="points"
                        min="0"
                        value="{{ old('points', $team->points) }}"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-400 focus:border-blue-400"
                    >
                </div>

                {{-- Creator (hidden) --}}
                <input
                    type="hidden"
                    name="creator_id"
                    value="{{ old('creator_id', $team->creator_id ?? '') }}"
                >

                {{-- Buttons --}}
                <div class="flex items-center gap-3 pt-3">

                    <button
                        type="submit"
                        class="px-5 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                        Opslaan
                    </button>

                    <a
                        href="{{ route('teams.index') }}"
                        class="px-5 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
                        Annuleer
                    </a>

                </div>

            </form>

        </div>

    </div>

</x-base-layout>
