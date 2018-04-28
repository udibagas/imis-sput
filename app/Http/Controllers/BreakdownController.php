<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Breakdown;
use App\Http\Requests\BreakdownRequest;
use Carbon\Carbon;

class BreakdownController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view', Breakdown::class);

        if ($request->ajax())
        {
            $pageSize = $request->rowCount > 0 ? $request->rowCount : 1000000;
            $request['page'] = $request->current;
            $sort = $request->sort ? key($request->sort) : 'time_in';
            $dir = $request->sort ? $request->sort[$sort] : 'desc';

            $breakdown = Breakdown::selectRaw('
                    breakdowns.*,
                    units.name AS unit,
                    locations.name AS location,
                    CONCAT(breakdown_categories.name, " - ", breakdown_categories.description_en) AS breakdown_category,
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
                ->when($request->searchPhrase, function($query) use ($request) {
                    return $query->where('units.name', 'LIKE', '%'.$request->searchPhrase.'%')
                        ->where('locations.name', 'LIKE', '%'.$request->searchPhrase.'%')
                        ->where('breakdown_categories.name', 'LIKE', '%'.$request->searchPhrase.'%')
                        ->where('breakdown_statuses.code', 'LIKE', '%'.$request->searchPhrase.'%');
                })->orderBy($sort, $dir)->paginate($pageSize);

            return [
                'rowCount' => $breakdown->perPage(),
                'total' => $breakdown->total(),
                'current' => $breakdown->currentPage(),
                'rows' => $breakdown->items(),
            ];
        }

        return view('breakdown.index', [
            'breadcrumbs' => [
                'plant/dashboard' => 'Plant',
                'breakdown' => 'Workshop'
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BreakdownRequest $request)
    {
        $this->authorize('create', Breakdown::class);
        $input = $request->all();
        $input['user_id'] = auth()->user()->id;
        $breakdown = Breakdown::create($input);
        $breakdown->unit->update(['status' => 0]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Breakdown $breakdown)
    {
        $this->authorize('view', Breakdown::class);
        return $breakdown;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BreakdownRequest $request, Breakdown $breakdown)
    {
        $this->authorize('update', Breakdown::class);
        $input = $request->all();
        $input['update_pcr_by'] = auth()->user()->id;
        $input['update_pcr_time'] = Carbon::now();
        $breakdown->update($input);
        $breakdown->unit->update(['status' => $breakdown->status]);
        return $breakdown;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Breakdown $breakdown)
    {
        $this->authorize('delete', Breakdown::class);
        return ['success' => $breakdown->delete()];
    }

    public function leadTimeBreakdownUnit(Request $request)
    {
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

        return view('breakdown.leadTimeBreakdownUnit', [
            'breadcrumbs' => [
                'plant/dashboard' => 'Plant',
                '#' => 'Lead Time Breakdown Unit'
            ]
        ]);
    }

    public function pcr(Request $request)
    {
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

    public function achievementDailyCheck()
    {
        return ['plan' => 20, 'actual' => 18];
    }

    public function todayPlanDailyCheck()
    {
        return [];
    }
}
