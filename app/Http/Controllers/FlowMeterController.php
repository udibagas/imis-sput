<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\FlowMeter;
use App\Http\Requests\FlowMeterRequest;

class FlowMeterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view', FlowMeter::class);

        if ($request->ajax())
        {
            $pageSize = $request->rowCount > 0 ? $request->rowCount : 1000000;
            $request['page'] = $request->current;
            $sort = $request->sort ? key($request->sort) : 'name';
            $dir = $request->sort ? $request->sort[$sort] : 'asc';

            $flowMeter = FlowMeter::selectRaw('
                    fuel_refills.*,
                    units.name AS unit,
                    unit_categories.name AS unit_category,
                    fuel_tanks.name AS fuel_tank,
                    employees.name AS employee_name,
                    employees.nrp AS nrp,
                    users.name AS insert_by
                ')
                ->join('units', 'units.id', '=', 'fuel_refills.unit_id')
                ->join('fuel_tanks', 'fuel_tanks.id', '=', 'fuel_refills.fuel_tank_id')
                ->join('employees', 'employees.id', '=', 'fuel_refills.employee_id')
                ->join('users', 'users.id', '=', 'fuel_refills.user_id')
                ->join('unit_categories', 'unit_categories.id', '=', 'units.unit_category_id')
                ->when($request->searchPhrase, function($query) use ($request) {
                    return $query->where('units.name', 'LIKE', '%'.$request->searchPhrase.'%')
                        ->orWhere('fuel_tanks.name', 'LIKE', '%'.$request->searchPhrase.'%')
                        ->orWhere('employees.nrp', 'LIKE', '%'.$request->searchPhrase.'%')
                        ->orWhere('users.name', 'LIKE', '%'.$request->searchPhrase.'%')
                        ->orWhere('unit_categories.name', 'LIKE', '%'.$request->searchPhrase.'%')
                        ->orWhere('employees.name', 'LIKE', '%'.$request->searchPhrase.'%');
                })->orderBy($sort, $dir)->paginate($pageSize);

            return [
                'rowCount' => $flowMeter->perPage(),
                'total' => $flowMeter->total(),
                'current' => $flowMeter->currentPage(),
                'rows' => $flowMeter->items(),
            ];
        }

        return view('flowMeter.index', [
            'breadcrumbs' => [
                'sm/dashboard' => 'SM',
                'flowMeter' => 'Flow Meter'
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FlowMeterRequest $request)
    {
        $this->authorize('create', FlowMeter::class);
        return FlowMeter::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(FlowMeter $flowMeter)
    {
        $this->authorize('view', FlowMeter::class);
        return $flowMeter;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(FlowMeterRequest $request, FlowMeter $flowMeter)
    {
        $this->authorize('update', FlowMeter::class);
        $flowMeter->update($request->all());
        return $flowMeter;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(FlowMeter $flowMeter)
    {
        $this->authorize('delete', FlowMeter::class);
        return ['success' => $flowMeter->delete()];
    }
}
