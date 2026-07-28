<?php

namespace App\Http\Controllers;

use App\Models\Holding;
use App\Models\Individual;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function __invoke(Request $request)
    {
        $query = $request->input('q', '');
        $type = $request->input('type');

        $individuals = collect();
        $holdings = collect();

        if ($query) {
            if (!$type || $type === 'individuals') {
                $individuals = Individual::search($query)->paginate(25, 'individuals_page');
            }
            if (!$type || $type === 'holdings') {
                $holdings = Holding::search($query)->paginate(25, 'holdings_page');
            }
        }

        return view('search.index', [
            'query' => $query,
            'type' => $type,
            'individuals' => $individuals,
            'holdings' => $holdings,
        ]);
    }
}
