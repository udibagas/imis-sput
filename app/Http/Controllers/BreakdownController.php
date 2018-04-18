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
        $pageSize = $request->rowCount > 0 ? $request->rowCount : 1000000;
        $request['page'] = $request->current;
        $sort = $request->sort ? key($request->sort) : 'time_in';
        $dir = $request->sort ? $request->sort[$sort] : 'desc';

        $breakdown = Breakdown::selectRaw('
                        breakdowns.*,
                        equipment.name AS equipment,
                        locations.name AS location,
                        breakdown_categories.name AS category,
                        breakdown_statuses.code AS breakdown_status
                    ')
                    ->when($request->searchPhrase, function($query) use ($request) {
                        return $query->where('equipment.name', 'LIKE', '%'.$request->searchPhrase.'%')
                                     ->where('locations.name', 'LIKE', '%'.$request->searchPhrase.'%')
                                     ->where('breakdown_categories.name', 'LIKE', '%'.$request->searchPhrase.'%')
                                     ->where('breakdown_statuses.code', 'LIKE', '%'.$request->searchPhrase.'%');
                    })->orderBy($sort, $dir)->paginate($pageSize);


        if ($request->ajax()) {
            return [
                'rowCount' => $breakdown->perPage(),
                'total' => $breakdown->total(),
                'current' => $breakdown->currentPage(),
                'rows' => $breakdown->items(),
            ];
        }

        return view('breakdown.index');
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
