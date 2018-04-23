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
        $this->authorize('view', SubUnit::class);

        if ($request->ajax())
        {
            $pageSize = $request->rowCount > 0 ? $request->rowCount : 1000000;
            $request['page'] = $request->current;
            $sort = $request->sort ? key($request->sort) : 'name';
            $dir = $request->sort ? $request->sort[$sort] : 'asc';

            $subUnit = SubUnit::when($request->searchPhrase, function($query) use ($request) {
                    return $query->where('name', 'LIKE', '%'.$request->searchPhrase.'%')
                        ->orWhere('description', 'LIKE', '%'.$request->searchPhrase.'%');
                })->orderBy($sort, $dir)->paginate($pageSize);

            return [
                'rowCount' => $subUnit->perPage(),
                'total' => $subUnit->total(),
                'current' => $subUnit->currentPage(),
                'rows' => $subUnit->items(),
            ];
        }

        return view('subUnit.index', [
            'breadcrumbs' => [
                'plant/dashboard' => 'Plant',
                '#' => 'Master Data',
                'subUnit' => 'Sub Unit'
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
        $this->authorize('create', SubUnit::class);
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
        $this->authorize('view', SubUnit::class);
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
        $this->authorize('update', SubUnit::class);
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
        $this->authorize('delete', SubUnit::class);
        return ['success' => $subUnit->delete()];
    }
}
