<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SubcontUnit;
use App\Http\Requests\SubcontUnitRequest;

class SubcontUnitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view', SubcontUnit::class);

        if ($request->ajax())
        {
            $pageSize = $request->rowCount > 0 ? $request->rowCount : 1000000;
            $request['page'] = $request->current;
            $sort = $request->sort ? key($request->sort) : 'name';
            $dir = $request->sort ? $request->sort[$sort] : 'asc';

            $subcontUnit = SubcontUnit::selectRaw('subcont_units.*, subconts.name AS subcont')
                ->join('subconts', 'subconts.id', '=', 'subcont_units.subcont_id')
                ->when($request->searchPhrase, function($query) use ($request) {
                    return $query->where('subcont_units.type', 'LIKE', '%'.$request->searchPhrase.'%')
                        ->orWhere('subcont_units.code_number', 'LIKE', '%'.$request->searchPhrase.'%')
                        ->orWhere('subcont_units.model', 'LIKE', '%'.$request->searchPhrase.'%')
                        ->orWhere('subconts.name', 'LIKE', '%'.$request->searchPhrase.'%');
                })->orderBy($sort, $dir)->paginate($pageSize);

            return [
                'rowCount' => $subcontUnit->perPage(),
                'total' => $subcontUnit->total(),
                'current' => $subcontUnit->currentPage(),
                'rows' => $subcontUnit->items(),
            ];
        }

        return view('subcontUnit.index', [
            'breadcrumbs' => [
                'operation' => 'Operation',
                '#' => 'Master Data',
                'subcontUnit' => 'Subcont Unit'
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SubcontUnitRequest $request)
    {
        $this->authorize('create', SubcontUnit::class);
        return SubcontUnit::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(SubcontUnit $subcontUnit)
    {
        $this->authorize('view', SubcontUnit::class);
        return $subcontUnit;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SubcontUnitRequest $request, SubcontUnit $subcontUnit)
    {
        $this->authorize('update', SubcontUnit::class);
        $subcontUnit->update($request->all());
        return $subcontUnit;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(SubcontUnit $subcontUnit)
    {
        $this->authorize('delete', SubcontUnit::class);
        return ['success' => $subcontUnit->delete()];
    }
}
