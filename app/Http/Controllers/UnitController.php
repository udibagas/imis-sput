<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Unit;
use App\Http\Requests\UnitRequest;

class UnitController extends Controller
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
        $sort = $request->sort ? key($request->sort) : 'units.name';
        $dir = $request->sort ? $request->sort[$sort] : 'asc';

        $units = Unit::selectRaw('
                        units.*,
                        owners.name AS owner,
                        egis.name AS egi,
                        alocations.name AS alocation,
                        unit_categories.name AS category,
                    ')
                    ->join('owners', 'owners.id', '=', 'units.owner_id')
                    ->join('egis', 'egis.id', '=', 'units.egi_id')
                    ->join('alocations', 'alocations.id', '=', 'units.alocation_id')
                    ->join('unit_categories', 'unit_categories.id', '=', 'units.unit_category_id', 'LEFT')
                    ->when($request->searchPhrase, function($query) use ($request) {
                        return $query->where('units.name', 'LIKE', '%'.$request->searchPhrase.'%')
                                     ->orWhere('owners.name', 'LIKE', '%'.$request->searchPhrase.'%')
                                     ->orWhere('egis.name', 'LIKE', '%'.$request->searchPhrase.'%')
                                     ->orWhere('alocations.name', 'LIKE', '%'.$request->searchPhrase.'%')
                                     ->orWhere('unit_categories.name', 'LIKE', '%'.$request->searchPhrase.'%');
                    })->orderBy($sort, $dir)->paginate($pageSize);


        if ($request->ajax()) {
            return [
                'rowCount' => $units->perPage(),
                'total' => $units->total(),
                'current' => $units->currentPage(),
                'rows' => $units->items(),
            ];
        }

        return view('unit.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UnitRequest $request)
    {
        return Unit::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Unit $unit)
    {
        return $unit;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UnitRequest $request, Unit $unit)
    {
        $unit->update($request->all());
        return $unit;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Unit $unit)
    {
        return ['success' => $unit->delete()];
    }
}
