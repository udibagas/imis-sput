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

        if (!$request->ajax())
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
                    users.name AS user
                ')
                ->join('units', 'units.id', '=', 'port_activities.unit_id')
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
                        ->orWhere('employees.name', 'LIKE', '%'.$request->searchPhrase.'%')
                        ->orWhere('customers.name', 'LIKE', '%'.$request->searchPhrase.'%')
                        ->orWhere('stock_areas.name', 'LIKE', '%'.$request->searchPhrase.'%');
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
                'operation' => 'Operation',
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
                    'volume' => $portActivity->materialStock->volume - $request->volume,
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
                        'volume_progress' => $bargingMaterial->volume_progress + $request->volume
                    ]);
                }

                else {
                    $barging->bargingMaterial()->create([
                        'contractor_id' => $request->contractor_id,
                        'material_type' => $request->material_type,
                        'seam_id' => $request->seam_id,
                        'volume_progress' => $request->volume,
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
        $this->authorize('view', PortActivity::class);
        $from = $request->from ? $request->from : date('Y-m-01');
        $to = $request->to ? $request->to : date('Y-m-d');

        $sql = "SELECT
            SUM(rit) AS bucket,
            SUM(COALESCE(volume, 0)) / 1000 AS volume,
            unit_activity_id,
            units.name AS unit,
            shift,
            e.name AS egi,
            0 AS plan
        FROM port_activities
        JOIN units ON units.id = port_activities.unit_id
        JOIN egis e ON e.id = units.egi_id
        WHERE `date` BETWEEN ? AND ?
        GROUP BY unit_id, unit_activity_id, shift";

        return DB::select($sql, [$from, $to]);
    }

    public function productivity(Request $request)
    {
        $this->authorize('view', PortActivity::class);

        if ($request->ajax())
        {
            $from = $request->from ? $request->from : date('Y-m-01');
            $to = $request->to ? $request->to : date('Y-m-d');

            $feeding = PortActivity::ACT_FEEDING;
            $loadAndCarry = PortActivity::ACT_LOAD_AND_CARRY;
            $loading = PortActivity::ACT_LOADING;
            $stockPiling = PortActivity::ACT_STOCKPILING;
            $hauling = PortActivity::ACT_HAULING;
            $standby = PortActivity::ACT_STANDBY;
            $breakdown = PortActivity::ACT_BREAKDOWN;

            $sql_unit = "SELECT
                units.name AS entity,
                pa.shift AS shift,
                SUM(COALESCE(volume, 0)) /1000 AS total,
                SUM(CASE WHEN pa.unit_activity_id = ".$feeding." THEN COALESCE(volume, 0) ELSE 0 END) / 1000 AS feeding,
                SUM(CASE WHEN pa.unit_activity_id = ".$loadAndCarry." THEN COALESCE(volume, 0) ELSE 0 END) / 1000 AS load_and_carry,
                SUM(CASE WHEN pa.unit_activity_id = ".$loading." THEN COALESCE(volume, 0) ELSE 0 END) / 1000 AS loading,
                SUM(CASE WHEN pa.unit_activity_id = ".$stockPiling." THEN COALESCE(volume, 0) ELSE 0 END) / 1000 AS stock_piling,
                SUM(CASE WHEN pa.unit_activity_id = ".$hauling." THEN COALESCE(volume, 0) ELSE 0 END) / 1000 hauling
                FROM port_activities pa
                JOIN units ON units.id = pa.unit_id
                WHERE pa.date BETWEEN '".$from."' AND '".$to."'
                GROUP BY pa.unit_id, pa.shift
            ";

            $sql_operator = "SELECT
                employees.name AS entity,
                pa.shift AS shift,

                SUM(COALESCE(volume, 0)) / 1000 / SUM(
                    CASE
                        WHEN pa.unit_activity_id != ".$standby." AND pa.unit_activity_id != ".$breakdown." AND pa.date BETWEEN '".$from."' AND '".$to."'
                            THEN IF(pa.time_end > pa.time_start,
                                TIME_TO_SEC(TIMEDIFF(pa.time_end, pa.time_start)) / 3600,
                                TIME_TO_SEC(TIMEDIFF(pa.time_end, pa.time_start)) / 3600 + (3600 * 24)
                            )
                        ELSE 0
                    END
                ) AS total,

                SUM(CASE WHEN pa.unit_activity_id = ".$feeding." THEN COALESCE(volume, 0) ELSE 0 END) / 1000 /
                    SUM(
                        CASE
                            WHEN pa.unit_activity_id = ".$feeding." AND pa.date BETWEEN '".$from."' AND '".$to."'
                                THEN IF(pa.time_end > pa.time_start,
                                    TIME_TO_SEC(TIMEDIFF(pa.time_end, pa.time_start)) / 3600,
                                    TIME_TO_SEC(TIMEDIFF(pa.time_end, pa.time_start)) / 3600 + (3600 * 24)
                                )
                            ELSE 0
                        END
                    ) AS feeding,

                SUM(CASE WHEN pa.unit_activity_id = ".$loadAndCarry." THEN COALESCE(volume, 0) ELSE 0 END) / 1000 /
                    SUM(
                        CASE
                            WHEN pa.unit_activity_id = ".$loadAndCarry." AND pa.date BETWEEN '".$from."' AND '".$to."'
                                THEN IF(pa.time_end > pa.time_start,
                                    TIME_TO_SEC(TIMEDIFF(pa.time_end, pa.time_start)) / 3600,
                                    TIME_TO_SEC(TIMEDIFF(pa.time_end, pa.time_start)) / 3600 + (3600 * 24)
                                )
                            ELSE 0
                        END
                    ) AS load_and_carry,

                SUM(CASE WHEN pa.unit_activity_id = ".$loading." THEN COALESCE(volume, 0) ELSE 0 END) / 1000 /
                    SUM(
                        CASE
                            WHEN pa.unit_activity_id = ".$loading." AND pa.date BETWEEN '".$from."' AND '".$to."'
                                THEN IF(pa.time_end > pa.time_start,
                                    TIME_TO_SEC(TIMEDIFF(pa.time_end, pa.time_start)) / 3600,
                                    TIME_TO_SEC(TIMEDIFF(pa.time_end, pa.time_start)) / 3600 + (3600 * 24)
                                )
                            ELSE 0
                        END
                    ) AS loading,

                SUM(CASE WHEN pa.unit_activity_id = ".$stockPiling." THEN COALESCE(volume, 0) ELSE 0 END) / 1000 /
                    SUM(
                        CASE
                            WHEN pa.unit_activity_id = ".$stockPiling." AND pa.date BETWEEN '".$from."' AND '".$to."'
                                THEN IF(pa.time_end > pa.time_start,
                                    TIME_TO_SEC(TIMEDIFF(pa.time_end, pa.time_start)) / 3600,
                                    TIME_TO_SEC(TIMEDIFF(pa.time_end, pa.time_start)) / 3600 + (3600 * 24)
                                )
                            ELSE 0
                        END
                    ) AS stock_piling,


                SUM(CASE WHEN pa.unit_activity_id = ".$hauling." THEN COALESCE(volume, 0) ELSE 0 END) / 1000 /
                    SUM(
                        CASE
                            WHEN pa.unit_activity_id = ".$hauling." AND pa.date BETWEEN '".$from."' AND '".$to."'
                                THEN IF(pa.time_end > pa.time_start,
                                    TIME_TO_SEC(TIMEDIFF(pa.time_end, pa.time_start)) / 3600,
                                    TIME_TO_SEC(TIMEDIFF(pa.time_end, pa.time_start)) / 3600 + (3600 * 24)
                                )
                            ELSE 0
                        END
                    ) AS hauling

                FROM port_activities pa
                JOIN employees ON employees.id = pa.employee_id
                WHERE pa.date BETWEEN '".$from."' AND '".$to."'
                GROUP BY pa.employee_id, pa.shift
            ";

            return DB::select($request->group == 'operator' ? $sql_operator : $sql_unit);
        }

        return view('portActivity.productivity', [
            'breadcrumbs' => [
                'operation' => 'Operation',
                'portActivity/productivity' => 'Productivity'
            ]
        ]);
    }

    public function export(Request $request)
    {
        $this->authorize('export', PortActivity::class);
        return Excel::download(new PortActivityExport($request), "port-activity-{$request->from}-to-{$request->to}.xlsx");
    }

}
