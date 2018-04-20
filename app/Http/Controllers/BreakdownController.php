<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Breakdown;
use App\Http\Requests\BreakdownRequest;

class BreakdownController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
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
                    breakdown_categories.name AS category,
                    breakdown_statuses.code AS breakdown_status
                ')
                ->join('units', 'units.id', '=', 'breakdowns.unit_id')
                ->join('locations', 'locations.id', '=', 'breakdowns.location_id')
                ->join('breakdown_categories', 'breakdown_categories.id', '=', 'breakdowns.breakdown_category_id')
                ->join('breakdown_statuses', 'breakdown_statuses.id', '=', 'breakdowns.breakdown_status_id', 'LEFT')
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
        return Breakdown::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Breakdown $breakdown)
    {
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
        $breakdown->update($request->all());
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
        return ['success' => $breakdown->delete()];
    }
}
