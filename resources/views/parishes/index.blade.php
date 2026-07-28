<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">Parishes</h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    @foreach($parishes as $parish)
                    <a href="{{ route('parishes.show', $parish) }}" class="block p-4 border border-gray-200 rounded-lg hover:border-indigo-300 hover:bg-indigo-50 transition">
                        <h3 class="font-medium text-gray-900">{{ $parish->name }}</h3>
                        <p class="text-sm text-gray-500">{{ $parish->holdings_count }} {{ Str::plural('holding', $parish->holdings_count) }}</p>
                    </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
