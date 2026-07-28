<?php

namespace App\Http\Controllers;

use App\Models\Holding;
use App\Models\Parish;

class ParishController extends Controller
{
    public function index()
    {
        $parishes = Parish::withCount(['holdings'])->orderBy('name')->get();

        return view('parishes.index', [
            'parishes' => $parishes,
        ]);
    }

    public function show(Parish $parish)
    {
        $holdings = Holding::where('parish_id', $parish->id)
            ->with('holdingMatches')
            ->orderBy('name')
            ->paginate(25);

        return view('parishes.show', [
            'parish' => $parish,
            'holdings' => $holdings,
        ]);
    }
}
