<?php

namespace App\Http\Controllers;

use App\Models\EnslavedMatch;
use App\Models\Holding;
use App\Models\Parish;
use Illuminate\Http\Request;

class HoldingController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('q');
        $parishId = $request->input('parish_id');

        if ($query) {
            $holdings = Holding::search($query)->paginate(25);
        } else {
            $builder = Holding::with('parish')->orderBy('name');
            if ($parishId) {
                $builder->where('parish_id', $parishId);
            }
            $holdings = $builder->paginate(25);
        }

        $parishes = Parish::orderBy('name')->get();

        return view('holdings.index', [
            'holdings' => $holdings,
            'parishes' => $parishes,
            'query' => $query,
            'parishId' => $parishId,
        ]);
    }

    public function show(Holding $holding)
    {
        $holding->load('parish');

        // Get entries linked to this holding (via holding_matches), with population data
        $entries = $holding->holdingMatches()
            ->with(['entry.parish', 'entry.enslaverRecords'])
            ->get()
            ->map(fn ($match) => $match->entry)
            ->filter()
            ->sortBy('register_year')
            ->values();

        // Population stats per register year
        $populationByYear = $entries->mapWithKeys(fn ($entry) => [
            $entry->register_year => [
                'total' => $entry->total_this_return,
                'males' => $entry->this_return_total_males,
                'females' => $entry->this_return_total_females,
                'previous_total' => $entry->total_last_return,
                'increase' => $entry->number_increase,
                'decrease' => $entry->number_decrease,
                'tna_ref' => $entry->tna_ref,
                'tna_page' => $entry->registers_page_number,
            ],
        ]);

        // Enslavers across all entries for this holding
        $enslavers = $entries->flatMap(function ($entry) {
            return $entry->enslaverRecords->map(fn ($record) => [
                'register_year' => $entry->register_year,
                'name_full' => $record->enslaver_name_full,
                'given_name' => $record->enslaver_given_name,
                'surname' => $record->enslaver_surname,
                'capacity' => $record->enslaver_capacity,
                'gender' => $record->enslaver_gender,
                'matched_individual_id' => $record->enslaverMatch?->individual_id,
            ]);
        });

        // Enslaved individuals at this holding (via entries → enslaved_records → enslaved_matches → individuals)
        $entryIds = $entries->pluck('id');
        $enslavedIndividuals = EnslavedMatch::whereHas('enslavedRecord', fn ($q) => $q->whereIn('entry_id', $entryIds))
            ->with(['individual', 'enslavedRecord'])
            ->get()
            ->groupBy('individual_id')
            ->map(function ($matches) {
                $individual = $matches->first()->individual;
                $years = $matches->pluck('enslavedRecord.register_year')->sort()->values();
                return [
                    'individual' => $individual,
                    'years' => $years,
                ];
            })
            ->sortBy(fn ($item) => $item['individual']->given_name)
            ->values();

        $annotations = $holding->annotations;

        return view('holdings.show', [
            'holding' => $holding,
            'populationByYear' => $populationByYear,
            'enslavers' => $enslavers,
            'enslavedIndividuals' => $enslavedIndividuals,
            'annotations' => $annotations,
        ]);
    }
}
