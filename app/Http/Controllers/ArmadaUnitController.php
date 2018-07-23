<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ArmadaUnit;
use App\Http\Requests\ArmadaUnitRequest;

class ArmadaUnitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view', ArmadaUnit::class);

        if ($request->ajax())
        {
            $pageSize = $request->rowCount > 0 ? $request->rowCount : 1000000;
            $request['page'] = $request->current;
            $sort = $request->sort ? key($request->sort) : 'name';
            $dir = $request->sort ? $request->sort[$sort] : 'asc';

            $armadaUnit = ArmadaUnit::selectRaw('armada_units.*, armadas.name AS armada')
                ->join('armadas', 'armadas.id', '=', 'armada_units.armada_id')
                ->when($request->searchPhrase, function($query) use ($request) {
                    return $query->where('armada_units.name', 'LIKE', '%'.$request->searchPhrase.'%')
                        ->orWhere('armada_units.register', 'LIKE', '%'.$request->searchPhrase.'%')
                        ->orWhere('armadas.name', 'LIKE', '%'.$request->searchPhrase.'%');
                })->orderBy($sort, $dir)->paginate($pageSize);

            return [
                'rowCount' => $armadaUnit->perPage(),
                'total' => $armadaUnit->total(),
                'current' => $armadaUnit->currentPage(),
                'rows' => $armadaUnit->items(),
            ];
        }

        return view('armadaUnit.index', [
            'breadcrumbs' => [
                'operation' => 'Operation',
                '#' => 'Master Data',
                'armadaUnit' => 'Armada Unit'
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ArmadaUnitRequest $request)
    {
        $this->authorize('create', ArmadaUnit::class);
        return ArmadaUnit::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(ArmadaUnit $armadaUnit)
    {
        $this->authorize('view', ArmadaUnit::class);
        return $armadaUnit;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ArmadaUnitRequest $request, ArmadaUnit $armadaUnit)
    {
        $this->authorize('update', ArmadaUnit::class);
        $armadaUnit->update($request->all());
        return $armadaUnit;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(ArmadaUnit $armadaUnit)
    {
        $this->authorize('delete', ArmadaUnit::class);
        return ['success' => $armadaUnit->delete()];
    }
}
