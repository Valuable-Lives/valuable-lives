<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">{{ $parish->name }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8 space-y-6">
            @if($parish->context_html)
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="prose prose-sm">{!! $parish->context_html !!}</div>
            </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-medium mb-4">Holdings in {{ $parish->name }} ({{ $holdings->total() }})</h3>
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Name</th>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Type</th>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Size</th>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Quality</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($holdings as $holding)
                        <tr>
                            <td class="px-4 py-2">
                                <a href="{{ route('holdings.show', $holding) }}" class="text-indigo-600 hover:text-indigo-800 font-medium">{{ $holding->name }}</a>
                            </td>
                            <td class="px-4 py-2 text-sm text-gray-600">{{ str_replace('_', ' ', $holding->type ?? '') }}</td>
                            <td class="px-4 py-2 text-sm text-gray-600">{{ str_replace('_', ' ', $holding->size_category ?? '') }}</td>
                            <td class="px-4 py-2 text-sm text-gray-600">{{ $holding->quality_flag }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="px-4 py-4 text-gray-500 text-center">No holdings in this parish.</td></tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="mt-4">{{ $holdings->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>
