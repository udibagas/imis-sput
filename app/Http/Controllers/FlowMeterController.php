<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\FlowMeter;
use App\Http\Requests\FlowMeterRequest;
use Carbon\Carbon;
use App\Exports\FlowMeterExport;
use Excel;

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
            $sort = $request->sort ? key($request->sort) : 'flow_meters.date';
            $dir = $request->sort ? $request->sort[$sort] : 'DESC';

            $flowMeter = FlowMeter::selectRaw('
                    flow_meters.*,
                    sadps.name AS sadp,
                    t.name AS transfer_to,
                    fuel_tanks.name AS fuel_tank,
                    users.name AS insert_by
                ')
                ->join('fuel_tanks', 'fuel_tanks.id', '=', 'flow_meters.fuel_tank_id', 'LEFT')
                ->join('fuel_tanks AS t', 't.id', '=', 'flow_meters.transfer_to_fuel_tank_id', 'LEFT')
                ->join('sadps', 'sadps.id', '=', 'flow_meters.sadp_id', 'LEFT')
                ->join('users', 'users.id', '=', 'flow_meters.user_id', 'LEFT')
                ->when($request->searchPhrase, function($query) use ($request) {
                    return $query->where('fuel_tanks.name', 'LIKE', '%'.$request->searchPhrase.'%');
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
        $input = $request->all();
        $input['user_id'] = auth()->user()->id;
        $flowMeter = FlowMeter::create($input);

        if ($flowMeter->status == 'S' && $flowMeter->fuelTank) {
            $flowMeter->fuelTank->update([
                'stock' => $request->volume_by_sounding,
                'last_stock_time' => Carbon::now()
            ]);
        }

        if ($flowMeter->status == 'T') {
            \App\FuelTank::where('id', $request->transfer_to_fuel_tank_id)->update([
                'stock' => $request->volume_by_sounding,
                'last_stock_time' => Carbon::now()
            ]);
        }

        return $flowMeter;
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

        if ($flowMeter->status == 'S' && $flowMeter->fuelTank) {
            $flowMeter->fuelTank->update([
                'stock' => $request->volume_by_sounding,
                'last_stock_time' => Carbon::now()
            ]);
        }

        if ($flowMeter->status == 'T') {
            \App\FuelTank::where('id', $request->transfer_to_fuel_tank_id)->update([
                'stock' => $request->volume_by_sounding,
                'last_stock_time' => Carbon::now()
            ]);
        }

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

    public function export(Request $request)
    {
        $this->authorize('export', FlowMeter::class);
        return Excel::download(new FlowMeterExport($request), "flowmeter-{$request->from}-to-{$request->to}.xlsx");
    }
}
