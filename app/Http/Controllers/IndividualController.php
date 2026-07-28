<?php

namespace App\Http\Controllers;

use App\Models\EnslavedMatch;
use App\Models\EnslavedRecord;
use App\Models\HoldingMatch;
use App\Models\Individual;
use Illuminate\Http\Request;

class IndividualController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('q');

        if ($query) {
            $individuals = Individual::search($query)->paginate(25);
        } else {
            $individuals = Individual::orderBy('surname')
                ->orderBy('given_name')
                ->paginate(25);
        }

        return view('individuals.index', [
            'individuals' => $individuals,
            'query' => $query,
        ]);
    }

    public function show(Individual $individual)
    {
        // Load enslaved records with their entries (for register data, holdings, TNA refs)
        $enslavedRecords = $individual->enslavedRecords()
            ->with(['entry.parish', 'entry.holdingMatches.holding.parish', 'increaseDecreases.incDecEnslavers', 'increaseDecreases.incDecParish'])
            ->orderBy('register_year')
            ->get();

        // Load enslaver records (if this person is also an enslaver)
        $enslaverRecords = $individual->enslaverRecords()
            ->with(['entry.holdingMatches.holding.parish', 'entry.parish'])
            ->orderBy('register_year')
            ->get();

        // Build per-year register data
        $registerData = $enslavedRecords->map(function (EnslavedRecord $record) {
            $holding = $record->entry?->holdingMatches->first()?->holding;
            return [
                'register_year' => $record->register_year,
                'age_years' => $record->age_years,
                'age_months' => $record->age_months,
                'colour' => $record->colour,
                'birthplace' => $record->birthplace,
                'occupation' => $record->occupation,
                'remarks' => $record->remarks,
                'holding' => $holding,
                'parish' => $record->entry?->parish,
                'tna_ref' => $record->tna_ref,
                'tna_page' => $record->registers_page_number,
                'entry_id' => $record->entry_id,
            ];
        });

        // Collect life events from increase/decrease records
        $lifeEvents = $enslavedRecords->flatMap(function (EnslavedRecord $record) {
            return $record->increaseDecreases->map(function ($event) use ($record) {
                return [
                    'register_year' => $record->register_year,
                    'increase_or_decrease' => $event->increase_or_decrease,
                    'type' => $event->type,
                    'full_text' => $event->full_text,
                    'day' => $event->day,
                    'month' => $event->month,
                    'year' => $event->year,
                    'parish' => $event->incDecParish,
                    'estate_name' => $event->inc_dec_estate_name,
                    'enslavers' => $event->incDecEnslavers,
                ];
            });
        })->sortBy('register_year')->values();

        // Collect unique holdings this person lived at
        $holdings = $registerData->pluck('holding')->filter()->unique('id')->values();

        // Load relationships (both directions)
        $relationships = $individual->relationshipsAsSubject()
            ->with(['person2', 'type'])
            ->get()
            ->map(fn ($r) => [
                'related_person' => $r->person2,
                'relationship' => $r->type->name,
                'source' => $r->source,
                'confidence' => $r->confidence,
            ])
            ->concat(
                $individual->relationshipsAsRelated()
                    ->with(['person1', 'type'])
                    ->get()
                    ->map(fn ($r) => [
                        'related_person' => $r->person1,
                        'relationship' => $r->type->inverse_name ?? $r->type->name,
                        'source' => $r->source,
                        'confidence' => $r->confidence,
                    ])
            );

        // Build enslaver role data (if this person is an enslaver)
        $enslaverData = $enslaverRecords->map(function ($record) {
            $holding = $record->entry?->holdingMatches->first()?->holding;
            return [
                'register_year' => $record->register_year,
                'capacity' => $record->enslaver_capacity,
                'holding' => $holding,
                'parish' => $record->entry?->parish,
            ];
        });

        $annotations = $individual->annotations;

        return view('individuals.show', [
            'individual' => $individual,
            'registerData' => $registerData,
            'lifeEvents' => $lifeEvents,
            'holdings' => $holdings,
            'relationships' => $relationships,
            'enslaverData' => $enslaverData,
            'annotations' => $annotations,
        ]);
    }
}
