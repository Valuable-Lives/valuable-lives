<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">{{ $holding->name }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8 space-y-6">
            {{-- Identity --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-medium mb-4">Holding Details</h3>
                <dl class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div><dt class="text-sm text-gray-500">Parish</dt><dd>{{ $holding->parish?->name ?? 'Unknown' }}</dd></div>
                    <div><dt class="text-sm text-gray-500">Type</dt><dd>{{ str_replace('_', ' ', $holding->type ?? 'Unknown') }}</dd></div>
                    <div><dt class="text-sm text-gray-500">Size category</dt><dd>{{ str_replace('_', ' ', $holding->size_category ?? 'Unknown') }}</dd></div>
                    <div><dt class="text-sm text-gray-500">Quality</dt><dd>{{ strtoupper($holding->quality_flag) }}</dd></div>
                    @if($holding->town_address)<div class="col-span-2"><dt class="text-sm text-gray-500">Address</dt><dd>{{ $holding->town_address }}</dd></div>@endif
                    @if($holding->latitude)<div><dt class="text-sm text-gray-500">Coordinates</dt><dd>{{ $holding->latitude }}, {{ $holding->longitude }}</dd></div>@endif
                    @if($holding->lbs_estate_id)<div><dt class="text-sm text-gray-500">LBS Estate</dt><dd>#{{ $holding->lbs_estate_id }}</dd></div>@endif
                </dl>
            </div>

            {{-- Population by year --}}
            @if($populationByYear->isNotEmpty())
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-medium mb-4">Population by Register Year</h3>
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th class="px-3 py-2 text-left text-sm font-medium text-gray-500">Year</th>
                            <th class="px-3 py-2 text-right text-sm font-medium text-gray-500">Total</th>
                            <th class="px-3 py-2 text-right text-sm font-medium text-gray-500">Males</th>
                            <th class="px-3 py-2 text-right text-sm font-medium text-gray-500">Females</th>
                            <th class="px-3 py-2 text-right text-sm font-medium text-gray-500">Previous</th>
                            <th class="px-3 py-2 text-right text-sm font-medium text-gray-500">Inc.</th>
                            <th class="px-3 py-2 text-right text-sm font-medium text-gray-500">Dec.</th>
                            <th class="px-3 py-2 text-left text-sm font-medium text-gray-500">TNA Ref</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($populationByYear as $year => $stats)
                        <tr>
                            <td class="px-3 py-2 font-medium">{{ $year }}</td>
                            <td class="px-3 py-2 text-right">{{ $stats['total'] }}</td>
                            <td class="px-3 py-2 text-right">{{ $stats['males'] }}</td>
                            <td class="px-3 py-2 text-right">{{ $stats['females'] }}</td>
                            <td class="px-3 py-2 text-right text-gray-500">{{ $stats['previous_total'] ?? '-' }}</td>
                            <td class="px-3 py-2 text-right text-green-600">{{ $stats['increase'] ?: '-' }}</td>
                            <td class="px-3 py-2 text-right text-red-600">{{ $stats['decrease'] ?: '-' }}</td>
                            <td class="px-3 py-2 text-sm text-gray-600">{{ $stats['tna_ref'] }} p.{{ $stats['tna_page'] }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif

            {{-- Enslavers --}}
            @if($enslavers->isNotEmpty())
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-medium mb-4">Enslavers</h3>
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th class="px-3 py-2 text-left text-sm font-medium text-gray-500">Year</th>
                            <th class="px-3 py-2 text-left text-sm font-medium text-gray-500">Name</th>
                            <th class="px-3 py-2 text-left text-sm font-medium text-gray-500">Capacity</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($enslavers as $enslaver)
                        <tr>
                            <td class="px-3 py-2">{{ $enslaver['register_year'] }}</td>
                            <td class="px-3 py-2">
                                @if($enslaver['matched_individual_id'])
                                    <a href="{{ route('individuals.show', $enslaver['matched_individual_id']) }}" class="text-indigo-600 hover:text-indigo-800">{{ $enslaver['name_full'] }}</a>
                                @else
                                    {{ $enslaver['name_full'] }}
                                @endif
                            </td>
                            <td class="px-3 py-2 text-sm text-gray-600">{{ $enslaver['capacity'] }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif

            {{-- Enslaved individuals --}}
            @if($enslavedIndividuals->isNotEmpty())
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-medium mb-4">Enslaved Persons ({{ $enslavedIndividuals->count() }})</h3>
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th class="px-3 py-2 text-left text-sm font-medium text-gray-500">Name</th>
                            <th class="px-3 py-2 text-left text-sm font-medium text-gray-500">Sex</th>
                            <th class="px-3 py-2 text-left text-sm font-medium text-gray-500">Colour</th>
                            <th class="px-3 py-2 text-left text-sm font-medium text-gray-500">Register Years</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($enslavedIndividuals as $item)
                        <tr>
                            <td class="px-3 py-2">
                                <a href="{{ route('individuals.show', $item['individual']) }}" class="text-indigo-600 hover:text-indigo-800 font-medium">
                                    {{ $item['individual']->given_name }} {{ $item['individual']->surname }}
                                </a>
                            </td>
                            <td class="px-3 py-2 text-sm text-gray-600">{{ $item['individual']->sex }}</td>
                            <td class="px-3 py-2 text-sm text-gray-600">{{ $item['individual']->colour }}</td>
                            <td class="px-3 py-2 text-sm text-gray-600">{{ $item['years']->join(', ') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif

            {{-- Annotations --}}
            @if($annotations->isNotEmpty())
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-medium mb-4">Notes</h3>
                @foreach($annotations as $annotation)
                <div class="mb-4 last:mb-0">
                    @if($annotation->title)<h4 class="font-medium text-gray-700">{{ $annotation->title }}</h4>@endif
                    <div class="prose prose-sm mt-1">{!! $annotation->content_html !!}</div>
                </div>
                @endforeach
            </div>
            @endif
        </div>
    </div>
</x-app-layout>
