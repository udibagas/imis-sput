<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PortActivity;
use App\Barging;
use App\BargingMaterial;
use App\Http\Requests\PortActivityRequest;
use App\Exports\PortActivityExport;
use Excel;
use DB;

class PortActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view', PortActivity::class);

        if ($request->ajax())
        {
            $pageSize = $request->rowCount > 0 ? $request->rowCount : 1000000;
            $request['page'] = $request->current;
            $sort = $request->sort ? key($request->sort) : 'port_activities.id';
            $dir = $request->sort ? $request->sort[$sort] : 'desc';

            $portActivity = PortActivity::selectRaw('
                    port_activities.*,
                    units.name AS unit,
                    areas.name AS area,
                    stock_areas.name AS stock_area,
                    employees.name AS employee,
                    customers.name AS customer,
                    contractors.name AS contractor,
                    seams.name AS seam,
                    hoppers.name AS hpr,
                    jetties.name AS jetty,
                    haulers.name AS hauler,
                    users.name AS user
                ')
                ->join('units', 'units.id', '=', 'port_activities.unit_id')
                ->join('units AS haulers', 'haulers.id', '=', 'port_activities.hauler_id', 'LEFT')
                ->join('material_stocks', 'material_stocks.id', '=', 'port_activities.material_stock_id', 'LEFT')
                ->join('stock_areas', 'stock_areas.id', '=', 'material_stocks.stock_area_id', 'LEFT')
                ->join('areas', 'areas.id', '=', 'stock_areas.area_id', 'LEFT')
                ->join('employees', 'employees.id', '=', 'port_activities.employee_id')
                ->join('customers', 'customers.id', '=', 'material_stocks.customer_id', 'LEFT')
                ->join('contractors', 'contractors.id', '=', 'material_stocks.contractor_id', 'LEFT')
                ->join('seams', 'seams.id', '=', 'material_stocks.seam_id', 'LEFT')
                ->join('hoppers', 'hoppers.id', '=', 'port_activities.hopper_id', 'LEFT')
                ->join('jetties', 'jetties.id', '=', 'hoppers.jetty_id', 'LEFT')
                ->join('users', 'users.id', '=', 'port_activities.user_id', 'LEFT')
                ->when($request->searchPhrase, function($query) use ($request) {
                    return $query->where('units.name', 'LIKE', '%'.$request->searchPhrase.'%')
                        ->where('employees.name', 'LIKE', '%'.$request->searchPhrase.'%')
                        ->where('customers.name', 'LIKE', '%'.$request->searchPhrase.'%')
                        ->where('unit_activities.name', 'LIKE', '%'.$request->searchPhrase.'%')
                        ->where('stock_areas.name', 'LIKE', '%'.$request->searchPhrase.'%');
                })->orderBy($sort, $dir)->paginate($pageSize);

            return [
                'rowCount' => $portActivity->perPage(),
                'total' => $portActivity->total(),
                'current' => $portActivity->currentPage(),
                'rows' => $portActivity->items(),
            ];
        }

        return view('portActivity.index', [
            'breadcrumbs' => [
                'operation/dashboard' => 'Operation',
                'portActivity' => 'Port Activity'
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PortActivityRequest $request)
    {
        $this->authorize('create', PortActivity::class);
        $input = $request->all();
        $input['user_id'] = auth()->user()->id;
        $portActivity = PortActivity::create($input);

        if ($request->unit_activity_id == PortActivity::ACT_LOAD_AND_CARRY
        || $request->unit_activity_id == PortActivity::ACT_FEEDING)
        {
            if ($portActivity->materialStock) {
                $portActivity->materialStock()->update([
                    'volume' => $portActivity->materialStock->volume - ($request->volume * 1000),
                ]);
            }

            $barging = Barging::where('jetty_id', $request->jetty_id)
                ->where('status', '!=', Barging::STATUS_COMPLETE)
                ->latest()->first();

            if ($barging)
            {
                $bargingMaterial = $barging->bargingMaterial()
                    ->where('material_type', $request->material_type)
                    ->where('seam_id', $request->seam_id)
                    ->where('contractor_id', $request->contractor_id)
                    ->first();

                if ($bargingMaterial) {
                    $bargingMaterial->update([
                        'volume_progress' => $bargingMaterial->volume_progress + ($request->volume * 1000)
                    ]);
                }

                else {
                    $barging->bargingMaterial()->create([
                        'contractor_id' => $request->contractor_id,
                        'material_type' => $request->material_type,
                        'seam_id' => $request->seam_id,
                        'volume_progress' => $request->volume * 1000,
                    ]);
                }
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(PortActivity $portActivity)
    {
        $this->authorize('view', PortActivity::class);
        return $portActivity;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PortActivityRequest $request, PortActivity $portActivity)
    {
        $this->authorize('update', PortActivity::class);
        $portActivity->update($request->all());
        return $portActivity;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(PortActivity $portActivity)
    {
        $this->authorize('delete', PortActivity::class);
        return ['success' => $portActivity->delete()];
    }

    public function summary(Request $request)
    {
        $from = $request->from ? $request->from : date('Y-m-01');
        $to = $request->to ? $request->to : date('Y-m-d');

        $sql = "SELECT
            SUM(rit) AS bucket,
            SUM(COALESCE(volume, 0)) / 1000 AS volume,
            unit_activity_id,
            units.name AS unit,
            shift,
            egis.name AS egi
        FROM port_activities
        JOIN units ON units.id = port_activities.unit_id
        JOIN egis ON egis.id = units.egi_id
        WHERE `date` BETWEEN ? AND ?
        GROUP BY unit_id, unit_activity_id, shift";

        return DB::select($sql, [$from, $to]);
    }

    public function productivity(Request $request)
    {
        $from = $request->from ? $request->from : date('Y-m-01');
        $to = $request->to ? $request->to : date('Y-m-d');

        $sql = "SELECT
            units.name AS unit,
            port_activities.shift,
            SUM(volume) /1000 AS total,
            SUM(CASE WHEN port_activities.unit_activity_id = ".PortActivity::ACT_FEEDING." THEN COALESCE(volume, 0) ELSE 0 END) / 1000 AS feeding,
            SUM(CASE WHEN port_activities.unit_activity_id = ".PortActivity::ACT_LOAD_AND_CARRY." THEN COALESCE(volume, 0) ELSE 0 END) / 1000 AS load_and_carry,
            SUM(CASE WHEN port_activities.unit_activity_id = ".PortActivity::ACT_LOADING." THEN COALESCE(volume, 0) ELSE 0 END) / 000 AS loading,
            SUM(CASE WHEN port_activities.unit_activity_id = ".PortActivity::ACT_STOCKPILING." THEN COALESCE(volume, 0) ELSE 0 END) / 1000 AS stock_piling,
            SUM(CASE WHEN port_activities.unit_activity_id = ".PortActivity::ACT_HAULING." THEN COALESCE(volume, 0) ELSE 0 END) / 1000 hauling
            FROM port_activities
            JOIN units ON units.id = port_activities.unit_id
            GROUP BY port_activities.unit_id, shift
        ";

        return DB::select($sql, [$from, $to]);
    }

    public function export(Request $request)
    {
        $this->authorize('export', PortActivity::class);
        return Excel::download(new PortActivityExport($request), "port-activity-{$request->from}-to-{$request->to}.xlsx");
    }

}
