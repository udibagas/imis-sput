<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\FuelTank;
use App\Egi;
use App\Http\Requests\FuelTankRequest;

class FuelTankController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view', FuelTank::class);

        if ($request->ajax())
        {
            $pageSize = $request->rowCount > 0 ? $request->rowCount : 1000000;
            $request['page'] = $request->current;
            $sort = $request->sort ? key($request->sort) : 'name';
            $dir = $request->sort ? $request->sort[$sort] : 'asc';

            $fuelTank = FuelTank::when($request->searchPhrase, function($query) use ($request) {
                    return $query->where('name', 'LIKE', '%'.$request->searchPhrase.'%')
                        ->orWhere('description', 'LIKE', '%'.$request->searchPhrase.'%');
                })->orderBy($sort, $dir)->paginate($pageSize);

            return [
                'rowCount' => $fuelTank->perPage(),
                'total' => $fuelTank->total(),
                'current' => $fuelTank->currentPage(),
                'rows' => $fuelTank->items(),
            ];
        }

        return view('fuelTank.index', [
            'breadcrumbs' => [
                'plant/dashboard' => 'SM',
                '#' => 'Master Data',
                'fuelTank' => 'Fuel Tank'
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FuelTankRequest $request)
    {
        $this->authorize('create', FuelTank::class);
        return FuelTank::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(FuelTank $fuelTank)
    {
        $this->authorize('view', FuelTank::class);
        return $fuelTank;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(FuelTankRequest $request, FuelTank $fuelTank)
    {
        $this->authorize('update', FuelTank::class);
        $fuelTank->update($request->all());
        return $fuelTank;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(FuelTank $fuelTank)
    {
        $this->authorize('delete', FuelTank::class);
        return ['success' => $fuelTank->delete()];
    }

    public function dashboard(Request $request)
    {
        $this->authorize('dashboard', FuelTank::class);

        if ($request->ajax()) {
            return FuelTank::orderBy('name', 'ASC')->get();
        }

        return view('fuelTank.dashboard', [
            'fuelTanks' => FuelTank::orderBy('name', 'ASC')->get(),
            'egi'=> Egi::orderBy('name', 'ASC')->get(),
            'breadcrumbs' => [
                '0' => 'SM',
                '#' => 'Dashboard'
            ]
        ]);
    }

    public function ratio(Request $request)
    {
        if ($request->ajax())
        {
            $labelSetting = [
                'show' => true,
                'position' => 'top',
            ];

            $rand1 = [];
            $rand2 = [];

            for ($i = 0; $i < 24; $i ++) {
                $rand1[] = rand(1,10);
                $rand2[] = rand(1,5);
            }

            return [[
                'name' => 'Duration',
                'type' => 'line',
                'label' => $labelSetting,
                'data' => $rand1
            ], [
                'name' => 'Fuel Ratio',
                'type' => 'bar',
                'label' => $labelSetting,
                'yAxisIndex' => 1,
                'data' => $rand2
            ]];
        }
    }
}
