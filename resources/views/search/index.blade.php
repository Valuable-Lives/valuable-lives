<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">Search</h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8 space-y-6">
            <form action="{{ route('search') }}" method="GET" class="flex gap-4">
                <input type="text" name="q" value="{{ $query }}" placeholder="Search individuals, holdings..." class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                <select name="type" class="rounded-md border-gray-300 shadow-sm">
                    <option value="">All types</option>
                    <option value="individuals" @selected($type === 'individuals')>Individuals</option>
                    <option value="holdings" @selected($type === 'holdings')>Holdings</option>
                </select>
                <button type="submit" class="rounded-md bg-indigo-600 px-4 py-2 text-white hover:bg-indigo-700">Search</button>
            </form>

            @if($query)
                @if(!$type || $type === 'individuals')
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-lg font-medium mb-4">Individuals ({{ $individuals instanceof \Illuminate\Pagination\AbstractPaginator ? $individuals->total() : $individuals->count() }})</h3>
                        @forelse($individuals as $individual)
                            <div class="py-2 border-b border-gray-100 last:border-0">
                                <a href="{{ route('individuals.show', $individual) }}" class="text-indigo-600 hover:text-indigo-800 font-medium">
                                    {{ $individual->given_name }} {{ $individual->surname }}
                                </a>
                                <span class="text-sm text-gray-500 ml-2">
                                    {{ $individual->sex }} &middot; {{ $individual->birthplace }} &middot; {{ $individual->colour }}
                                    @if($individual->estimated_birth_year) &middot; b. ~{{ $individual->estimated_birth_year }} @endif
                                </span>
                            </div>
                        @empty
                            <p class="text-gray-500">No individuals found.</p>
                        @endforelse
                        @if($individuals instanceof \Illuminate\Pagination\AbstractPaginator)
                            <div class="mt-4">{{ $individuals->appends(['q' => $query, 'type' => $type])->links() }}</div>
                        @endif
                    </div>
                @endif

                @if(!$type || $type === 'holdings')
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-lg font-medium mb-4">Holdings ({{ $holdings instanceof \Illuminate\Pagination\AbstractPaginator ? $holdings->total() : $holdings->count() }})</h3>
                        @forelse($holdings as $holding)
                            <div class="py-2 border-b border-gray-100 last:border-0">
                                <a href="{{ route('holdings.show', $holding) }}" class="text-indigo-600 hover:text-indigo-800 font-medium">
                                    {{ $holding->name }}
                                </a>
                                <span class="text-sm text-gray-500 ml-2">
                                    {{ $holding->type }} &middot; {{ $holding->parish?->name ?? 'Unknown parish' }}
                                </span>
                            </div>
                        @empty
                            <p class="text-gray-500">No holdings found.</p>
                        @endforelse
                        @if($holdings instanceof \Illuminate\Pagination\AbstractPaginator)
                            <div class="mt-4">{{ $holdings->appends(['q' => $query, 'type' => $type])->links() }}</div>
                        @endif
                    </div>
                @endif
            @else
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <p class="text-gray-500">Enter a search term to find individuals or holdings.</p>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
