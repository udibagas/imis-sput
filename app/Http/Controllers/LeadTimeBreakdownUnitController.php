<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use App\Breakdown;

class LeadTimeBreakdownUnitController extends Controller
{
    public function index(Request $request)
    {
        if (Gate::denies('view-leadtime-breakdown-unit')) {
            abort(403, 'Unauthorized action.');
        }

        if ($request->ajax())
        {
            return Breakdown::selectRaw('
                    breakdowns.*,
                    units.name AS unit,
                    locations.name AS location,
                    breakdown_categories.name AS breakdown_category,
                    breakdown_statuses.code AS breakdown_status,
                    unit_categories.name AS unit_category,
                    CONCAT(component_criterias.code, " - ", component_criterias.description) AS component_criteria
                ')
                ->join('units', 'units.id', '=', 'breakdowns.unit_id')
                ->join('unit_categories', 'unit_categories.id', '=', 'units.unit_category_id')
                ->join('locations', 'locations.id', '=', 'breakdowns.location_id')
                ->join('breakdown_categories', 'breakdown_categories.id', '=', 'breakdowns.breakdown_category_id')
                ->join('breakdown_statuses', 'breakdown_statuses.id', '=', 'breakdowns.breakdown_status_id', 'LEFT')
                ->join('component_criterias', 'component_criterias.id', '=', 'breakdowns.component_criteria_id', 'LEFT')
                ->where('breakdowns.status', 0)
                ->when($request->searchPhrase, function($query) use ($request) {
                    return $query->where('units.name', 'LIKE', '%'.$request->searchPhrase.'%')
                        ->orWhere('breakdowns.wo_number', 'LIKE', '%'.$request->searchPhrase.'%')
                        ->orWhere('unit_categories.name', 'LIKE', '%'.$request->searchPhrase.'%')
                        ->orWhere('locations.name', 'LIKE', '%'.$request->searchPhrase.'%')
                        ->orWhere('breakdown_categories.name', 'LIKE', '%'.$request->searchPhrase.'%')
                        ->orWhere('breakdown_statuses.code', 'LIKE', '%'.$request->searchPhrase.'%')
                        ->orWhere('component_criterias.code', 'LIKE', '%'.$request->searchPhrase.'%')
                        ->orWhere('component_criterias.description', 'LIKE', '%'.$request->searchPhrase.'%');
                })
                ->orderBy('created_at', 'DESC')
                ->get();
        }

        return view('breakdown.leadTimeBreakdownUnit', [
            'breadcrumbs' => [
                'plant/dashboard' => 'Plant',
                '#' => 'Lead Time Breakdown Unit'
            ]
        ]);
    }
}
