<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use App\Pitstop;

class LeadTimeDailyCheckController extends Controller
{
    public function index(Request $request)
    {
        if (Gate::denies('view-leadtime-daily-check')) {
            abort(403, 'Unauthorized action.');
        }

        if ($request->ajax())
        {
            return Pitstop::selectRaw('
                    pitstops.*,
                    units.name AS unit,
                    locations.name AS location
                ')
                ->join('units', 'units.id', '=', 'pitstops.unit_id')
                ->join('locations', 'locations.id', '=', 'pitstops.location_id')
                ->join('unit_categories', 'unit_categories.id', '=', 'units.unit_category_id')
                ->where('pitstops.status', 0)
                ->when($request->searchPhrase, function($query) use ($request) {
                    return $query->where('locations.name', 'LIKE', '%'.$request->searchPhrase.'%')
                        ->orWhere('units.name', 'LIKE', '%'.$request->searchPhrase.'%')
                        ->orWhere('unit_categories.name', 'LIKE', '%'.$request->searchPhrase.'%')
                        ->orWhere('locations.name', 'LIKE', '%'.$request->searchPhrase.'%')
                        ->orWhere('pitstops.description', 'LIKE', '%'.$request->searchPhrase.'%');
                })->orderBy('pitstops.created_at', 'DESC')->get();
        }

        return view('pitstop.leadTimeDailyCheck', [
            'breadcrumbs' => [
                'plant/dashboard' => 'Plant',
                '#' => 'Lead Time Daily Check'
            ]
        ]);
    }
}
