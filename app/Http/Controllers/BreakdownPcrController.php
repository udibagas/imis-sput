<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use App\Http\Requests\BreakdownRequest;
use App\Breakdown;
use Carbon\Carbon;

class BreakdownPcrController extends Controller
{
    public function index(Request $request)
    {
        if (Gate::denies('view-breakdown-pcr')) {
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
                ->orderBy('created_at', 'DESC')
                ->get();
        }

        return view('breakdown.pcr', [
            'breadcrumbs' => [
                '#' => 'Plant',
                'breakdown/pcr' => 'Breakdown PCR'
            ]
        ]);
    }

    public function show(Breakdown $breakdown)
    {
        if (Gate::denies('view-breakdown-pcr')) {
            abort(403, 'Unauthorized action.');
        }

        return $breakdown;
    }

    public function update(BreakdownRequest $request, Breakdown $breakdown)
    {
        if (Gate::denies('update-breakdown-pcr')) {
            abort(403, 'Unauthorized action.');
        }

        $input = $request->all();
        $input['update_pcr_by'] = auth()->user()->id;
        $input['update_pcr_time'] = Carbon::now();

        if ($request->status == 1) {
            $input['time_close'] = Carbon::now();
        }

        $breakdown->update($input);
        $breakdown->unit->update(['status' => $breakdown->status]);

        if ($request->warning_part && !$breakdown->warningPart) {
            $breakdown->warningPart()->create();
        }

        return $breakdown;
    }
}
