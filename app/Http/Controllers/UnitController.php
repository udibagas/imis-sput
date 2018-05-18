<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Unit;
use App\Exports\UnitExport;
use App\Http\Requests\UnitRequest;
use DB;
use Excel;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view', Unit::class);

        if ($request->ajax())
        {
            $pageSize = $request->rowCount > 0 ? $request->rowCount : 1000000;
            $request['page'] = $request->current;
            $sort = $request->sort ? key($request->sort) : 'units.name';
            $dir = $request->sort ? $request->sort[$sort] : 'asc';

            $units = Unit::selectRaw('
                    units.*,
                    owners.name AS owner,
                    egis.name AS egi,
                    egis.fc AS fc,
                    unit_categories.name AS category
                ')
                ->join('owners', 'owners.id', '=', 'units.owner_id')
                ->join('egis', 'egis.id', '=', 'units.egi_id')
                ->join('unit_categories', 'unit_categories.id', '=', 'units.unit_category_id', 'LEFT')
                ->when($request->searchPhrase, function($query) use ($request) {
                    return $query->where('units.name', 'LIKE', '%'.$request->searchPhrase.'%')
                        ->orWhere('owners.name', 'LIKE', '%'.$request->searchPhrase.'%')
                        ->orWhere('egis.name', 'LIKE', '%'.$request->searchPhrase.'%')
                        ->orWhere('unit_categories.name', 'LIKE', '%'.$request->searchPhrase.'%');
                })->orderBy($sort, $dir)->paginate($pageSize);

            return [
                'rowCount' => $units->perPage(),
                'total' => $units->total(),
                'current' => $units->currentPage(),
                'rows' => $units->items(),
            ];
        }

        return view('unit.index', [
            'breadcrumbs' => [
                'plant/dashboard' => 'Plant',
                '#' => 'Master Data',
                'unit' => 'Units'
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UnitRequest $request)
    {
        $this->authorize('create', Unit::class);
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
        $this->authorize('view', Unit::class);
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
        $this->authorize('update', Unit::class);
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
        $this->authorize('delete', Unit::class);
        return ['success' => $unit->delete()];
    }

    public function remarkUnitByType()
    {
        $sql = "SELECT
                uc.name AS category,
                (SELECT COUNT(id) FROM units WHERE status = 1 AND unit_category_id = uc.id) AS ready,
                (SELECT COUNT(id) FROM units WHERE status = 0 AND unit_category_id = uc.id) AS breakdown
            FROM unit_categories uc ORDER BY name ASC
        ";

        return DB::select(DB::raw($sql));
    }

    public function export(Request $request)
    {
        $this->authorize('export', Unit::class);
        return Excel::download(new UnitExport($request), 'units.xlsx');
    }
}
