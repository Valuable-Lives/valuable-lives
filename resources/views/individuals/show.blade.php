<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ $individual->prefix }} {{ $individual->given_name }} {{ $individual->surname }} {{ $individual->suffix }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8 space-y-6">
            {{-- Identity --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-medium mb-4">Identity</h3>
                <dl class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div><dt class="text-sm text-gray-500">Sex</dt><dd>{{ $individual->sex ?? 'Unknown' }}</dd></div>
                    <div><dt class="text-sm text-gray-500">Colour</dt><dd>{{ $individual->colour ?? 'Not recorded' }}</dd></div>
                    <div><dt class="text-sm text-gray-500">Birthplace</dt><dd>{{ $individual->birthplace ?? 'Unknown' }}{{ $individual->country_nation ? ' ('.$individual->country_nation.')' : '' }}</dd></div>
                    <div><dt class="text-sm text-gray-500">Estimated birth</dt><dd>{{ $individual->estimated_birth_year ? '~'.$individual->estimated_birth_year : 'Unknown' }}</dd></div>
                    @if($individual->death_year)<div><dt class="text-sm text-gray-500">Death</dt><dd>{{ $individual->death_year }}</dd></div>@endif
                    @if($individual->appearance)<div class="col-span-2"><dt class="text-sm text-gray-500">Appearance</dt><dd>{{ $individual->appearance }}</dd></div>@endif
                    @if($individual->lbs_individual_id)<div><dt class="text-sm text-gray-500">LBS link</dt><dd>Individual #{{ $individual->lbs_individual_id }}</dd></div>@endif
                </dl>
            </div>

            {{-- Register records --}}
            @if($registerData->isNotEmpty())
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-medium mb-4">Register Records</h3>
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th class="px-3 py-2 text-left text-sm font-medium text-gray-500">Year</th>
                            <th class="px-3 py-2 text-left text-sm font-medium text-gray-500">Age</th>
                            <th class="px-3 py-2 text-left text-sm font-medium text-gray-500">Holding</th>
                            <th class="px-3 py-2 text-left text-sm font-medium text-gray-500">Parish</th>
                            <th class="px-3 py-2 text-left text-sm font-medium text-gray-500">Occupation</th>
                            <th class="px-3 py-2 text-left text-sm font-medium text-gray-500">TNA Ref</th>
                            <th class="px-3 py-2 text-left text-sm font-medium text-gray-500">Remarks</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($registerData as $record)
                        <tr>
                            <td class="px-3 py-2 font-medium">{{ $record['register_year'] }}</td>
                            <td class="px-3 py-2">{{ $record['age_years'] }}{{ $record['age_months'] ? 'm'.$record['age_months'] : '' }}</td>
                            <td class="px-3 py-2">
                                @if($record['holding'])
                                    <a href="{{ route('holdings.show', $record['holding']) }}" class="text-indigo-600 hover:text-indigo-800">{{ $record['holding']->name }}</a>
                                @else
                                    -
                                @endif
                            </td>
                            <td class="px-3 py-2 text-sm text-gray-600">{{ $record['parish']?->name }}</td>
                            <td class="px-3 py-2 text-sm text-gray-600">{{ $record['occupation'] ?? '-' }}</td>
                            <td class="px-3 py-2 text-sm text-gray-600">{{ $record['tna_ref'] }} p.{{ $record['tna_page'] }}</td>
                            <td class="px-3 py-2 text-sm text-gray-600">{{ $record['remarks'] ?? '-' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif

            {{-- Life events --}}
            @if($lifeEvents->isNotEmpty())
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-medium mb-4">Life Events</h3>
                <div class="space-y-3">
                    @foreach($lifeEvents as $event)
                    <div class="flex items-start gap-3 py-2 border-b border-gray-100 last:border-0">
                        <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium {{ $event['increase_or_decrease'] === 'increase' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $event['type'] }}
                        </span>
                        <div>
                            <p class="text-sm">{{ $event['full_text'] }}</p>
                            <p class="text-xs text-gray-500">
                                Register: {{ $event['register_year'] }}
                                @if($event['year']) &middot; Date: {{ $event['day'] ? $event['day'].'/' : '' }}{{ $event['month'] ? $event['month'].'/' : '' }}{{ $event['year'] }} @endif
                                @if($event['parish']) &middot; {{ $event['parish']->name }} @endif
                                @if($event['estate_name']) &middot; {{ $event['estate_name'] }} @endif
                            </p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Holdings --}}
            @if($holdings->isNotEmpty())
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-medium mb-4">Holdings / Residences</h3>
                <ul class="space-y-2">
                    @foreach($holdings as $holding)
                    <li>
                        <a href="{{ route('holdings.show', $holding) }}" class="text-indigo-600 hover:text-indigo-800 font-medium">{{ $holding->name }}</a>
                        <span class="text-sm text-gray-500">{{ $holding->parish?->name }} &middot; {{ $holding->type }}</span>
                    </li>
                    @endforeach
                </ul>
            </div>
            @endif

            {{-- Relationships --}}
            @if($relationships->isNotEmpty())
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-medium mb-4">Relationships</h3>
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th class="px-3 py-2 text-left text-sm font-medium text-gray-500">Relationship</th>
                            <th class="px-3 py-2 text-left text-sm font-medium text-gray-500">Person</th>
                            <th class="px-3 py-2 text-left text-sm font-medium text-gray-500">Source</th>
                            <th class="px-3 py-2 text-left text-sm font-medium text-gray-500">Confidence</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($relationships as $rel)
                        <tr>
                            <td class="px-3 py-2">{{ $rel['relationship'] }}</td>
                            <td class="px-3 py-2">
                                <a href="{{ route('individuals.show', $rel['related_person']) }}" class="text-indigo-600 hover:text-indigo-800">
                                    {{ $rel['related_person']->given_name }} {{ $rel['related_person']->surname }}
                                </a>
                            </td>
                            <td class="px-3 py-2 text-sm text-gray-600">{{ $rel['source'] }}</td>
                            <td class="px-3 py-2 text-sm text-gray-600">{{ $rel['confidence'] }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif

            {{-- Enslaver roles (if this person is also an enslaver) --}}
            @if($enslaverData->isNotEmpty())
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-medium mb-4">Enslaver Roles</h3>
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th class="px-3 py-2 text-left text-sm font-medium text-gray-500">Year</th>
                            <th class="px-3 py-2 text-left text-sm font-medium text-gray-500">Capacity</th>
                            <th class="px-3 py-2 text-left text-sm font-medium text-gray-500">Holding</th>
                            <th class="px-3 py-2 text-left text-sm font-medium text-gray-500">Parish</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($enslaverData as $role)
                        <tr>
                            <td class="px-3 py-2">{{ $role['register_year'] }}</td>
                            <td class="px-3 py-2">{{ $role['capacity'] }}</td>
                            <td class="px-3 py-2">
                                @if($role['holding'])
                                    <a href="{{ route('holdings.show', $role['holding']) }}" class="text-indigo-600 hover:text-indigo-800">{{ $role['holding']->name }}</a>
                                @else - @endif
                            </td>
                            <td class="px-3 py-2 text-sm text-gray-600">{{ $role['parish']?->name }}</td>
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
