<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\WarningPart;
use App\Http\Requests\WarningPartRequest;
use Carbon\Carbon;

class WarningPartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view', WarningPart::class);

        if ($request->ajax())
        {
            $pageSize = $request->rowCount > 0 ? $request->rowCount : 1000000;
            $request['page'] = $request->current;
            $sort = $request->sort ? key($request->sort) : 'breakdowns.time_in';
            $dir = $request->sort ? $request->sort[$sort] : 'desc';

            $warningPart = WarningPart::selectRaw('
                    warning_parts.*,
                    units.name AS unit,
                    locations.name AS location,
                    CONCAT(breakdown_categories.name, " - ", breakdown_categories.description_en) AS breakdown_category,
                    breakdown_statuses.code AS breakdown_status,
                    unit_categories.name AS unit_category,
                    CONCAT(component_criterias.code, " - ", component_criterias.description) AS component_criteria
                ')
                ->join('breakdowns', 'breakdowns.id', '=', 'warning_parts.breakdown_id')
                ->join('units', 'units.id', '=', 'breakdowns.unit_id')
                ->join('breakdown_categories', 'breakdown_categories.id', '=', 'breakdowns.breakdown_category_id')
                ->join('locations', 'locations.id', '=', 'breakdowns.location_id')
                ->join('unit_categories', 'unit_categories.id', '=', 'units.unit_category_id')
                ->join('breakdown_statuses', 'breakdown_statuses.id', '=', 'breakdowns.breakdown_status_id', 'LEFT')
                ->join('component_criterias', 'component_criterias.id', '=', 'breakdowns.component_criteria_id', 'LEFT')
                ->when($request->searchPhrase, function($query) use ($request) {
                    return $query->where('units.name', 'LIKE', '%'.$request->searchPhrase.'%')
                        ->where('locations.name', 'LIKE', '%'.$request->searchPhrase.'%')
                        ->where('breakdown_categories.name', 'LIKE', '%'.$request->searchPhrase.'%')
                        ->where('breakdown_statuses.code', 'LIKE', '%'.$request->searchPhrase.'%');
                })->orderBy($sort, $dir)->paginate($pageSize);

            return [
                'rowCount' => $warningPart->perPage(),
                'total' => $warningPart->total(),
                'current' => $warningPart->currentPage(),
                'rows' => $warningPart->items(),
            ];
        }

        return view('warningPart.index', [
            'breadcrumbs' => [
                'plant/dashboard' => 'Plant',
                'warningPart' => 'Workshop'
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(WarningPartRequest $request)
    {
        $this->authorize('create', WarningPart::class);
        $input = $request->all();
        $input['user_id'] = auth()->user()->id;
        $warningPart = WarningPart::create($input);
        $warningPart->unit->update(['status' => 0]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(WarningPart $warningPart)
    {
        $this->authorize('view', WarningPart::class);
        return $warningPart;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(WarningPartRequest $request, WarningPart $warningPart)
    {
        $this->authorize('update', WarningPart::class);
        $warningPart->update($request->all());
        return $warningPart;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(WarningPart $warningPart)
    {
        $this->authorize('delete', WarningPart::class);
        return ['success' => $warningPart->delete()];
    }
}
