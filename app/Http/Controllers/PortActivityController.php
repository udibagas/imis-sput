<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PortActivity;
use App\Http\Requests\PortActivityRequest;

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
            $sort = $request->sort ? key($request->sort) : 'port_activities.date';
            $dir = $request->sort ? $request->sort[$sort] : 'desc';

            $portActivity = PortActivity::selectRaw('
                    port_activities.*,
                    units.name AS unit,
                    CONCAT("Jetty ", jetties.name, " - ", stock_areas.name) AS area,
                    employees.name AS employee,
                    customers.name AS customer,
                    unit_activities.name AS activity,
                    seams.name AS seam,
                    hoppers.name AS hopper,
                    haulers.name AS hauler
                ')
                ->join('units', 'units.id', '=', 'port_activities.unit_id')
                ->join('units AS haulers', 'haulers.id', '=', 'port_activities.hauler_id', 'LEFT')
                ->join('stock_areas', 'stock_areas.id', '=', 'port_activities.stock_area_id')
                ->join('jetties', 'jetties.id', '=', 'stock_areas.jetty_id')
                ->join('employees', 'employees.id', '=', 'port_activities.employee_id')
                ->join('customers', 'customers.id', '=', 'port_activities.customer_id')
                ->join('unit_activities', 'unit_activities.id', '=', 'port_activities.unit_activity_id')
                ->join('seams', 'seams.id', '=', 'port_activities.seam_id', 'LEFT')
                ->join('hoppers', 'hoppers.id', '=', 'port_activities.hopper_id', 'LEFT')
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
        // $input['user_id'] = auth()->user()->id;
        return PortActivity::create($input);
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
}
