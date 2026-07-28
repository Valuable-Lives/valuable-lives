<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">Holdings</h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8 space-y-6">
            <form action="{{ route('holdings.index') }}" method="GET" class="flex gap-4">
                <input type="text" name="q" value="{{ $query }}" placeholder="Search holdings..." class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                <select name="parish_id" class="rounded-md border-gray-300 shadow-sm" onchange="this.form.submit()">
                    <option value="">All parishes</option>
                    @foreach($parishes as $parish)
                        <option value="{{ $parish->id }}" @selected($parishId == $parish->id)>{{ $parish->name }}</option>
                    @endforeach
                </select>
                <button type="submit" class="rounded-md bg-indigo-600 px-4 py-2 text-white hover:bg-indigo-700">Search</button>
            </form>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Name</th>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Parish</th>
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
                                <td class="px-4 py-2 text-sm text-gray-600">{{ $holding->parish?->name }}</td>
                                <td class="px-4 py-2 text-sm text-gray-600">{{ str_replace('_', ' ', $holding->type ?? '') }}</td>
                                <td class="px-4 py-2 text-sm text-gray-600">{{ str_replace('_', ' ', $holding->size_category ?? '') }}</td>
                                <td class="px-4 py-2 text-sm text-gray-600">{{ $holding->quality_flag }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="px-4 py-4 text-gray-500 text-center">No holdings found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="mt-4">{{ $holdings->appends(['q' => $query, 'parish_id' => $parishId])->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>
