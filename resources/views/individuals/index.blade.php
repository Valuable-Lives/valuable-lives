<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">Individuals</h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8 space-y-6">
            <form action="{{ route('individuals.index') }}" method="GET" class="flex gap-4">
                <input type="text" name="q" value="{{ $query }}" placeholder="Search by name..." class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                <button type="submit" class="rounded-md bg-indigo-600 px-4 py-2 text-white hover:bg-indigo-700">Search</button>
            </form>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Name</th>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Sex</th>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Birthplace</th>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Colour</th>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Birth</th>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Death</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($individuals as $individual)
                            <tr>
                                <td class="px-4 py-2">
                                    <a href="{{ route('individuals.show', $individual) }}" class="text-indigo-600 hover:text-indigo-800 font-medium">
                                        {{ $individual->prefix }} {{ $individual->given_name }} {{ $individual->surname }} {{ $individual->suffix }}
                                    </a>
                                </td>
                                <td class="px-4 py-2 text-sm text-gray-600">{{ $individual->sex }}</td>
                                <td class="px-4 py-2 text-sm text-gray-600">{{ $individual->birthplace }}</td>
                                <td class="px-4 py-2 text-sm text-gray-600">{{ $individual->colour }}</td>
                                <td class="px-4 py-2 text-sm text-gray-600">{{ $individual->estimated_birth_year ? '~'.$individual->estimated_birth_year : '' }}</td>
                                <td class="px-4 py-2 text-sm text-gray-600">{{ $individual->death_year }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="px-4 py-4 text-gray-500 text-center">No individuals found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="mt-4">{{ $individuals->appends(['q' => $query])->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>
