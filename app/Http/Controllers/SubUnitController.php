<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SubUnit;
use App\Http\Requests\SubUnitRequest;

class SubUnitController extends Controller
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
        $sort = $request->sort ? key($request->sort) : 'name';
        $dir = $request->sort ? $request->sort[$sort] : 'asc';

        $subUnit = SubUnit::when($request->searchPhrase, function($query) use ($request) {
                        return $query->where('name', 'LIKE', '%'.$request->searchPhrase.'%')
                                     ->orWhere('description', 'LIKE', '%'.$request->searchPhrase.'%');
                    })->orderBy($sort, $dir)->paginate($pageSize);


        if ($request->ajax()) {
            return [
                'rowCount' => $subUnit->perPage(),
                'total' => $subUnit->total(),
                'current' => $subUnit->currentPage(),
                'rows' => $subUnit->items(),
            ];
        }

        return view('subUnit.index', [
            'breadcrumbs' => [
                '#' => 'Sub Unit'
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SubUnitRequest $request)
    {
        return SubUnit::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(SubUnit $subUnit)
    {
        return $subUnit;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SubUnitRequest $request, SubUnit $subUnit)
    {
        $subUnit->update($request->all());
        return $subUnit;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(SubUnit $subUnit)
    {
        return ['success' => $subUnit->delete()];
    }
}
