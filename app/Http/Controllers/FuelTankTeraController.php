<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\FuelTankTera;
use App\Egi;
use App\Http\Requests\FuelTankTeraRequest;

class FuelTankTeraController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view', FuelTankTera::class);

        if ($request->ajax())
        {
            $pageSize = $request->rowCount > 0 ? $request->rowCount : 1000000;
            $request['page'] = $request->current;
            $sort = $request->sort ? key($request->sort) : 'id';
            $dir = $request->sort ? $request->sort[$sort] : 'asc';

            $fuelTankTera = FuelTankTera::selectRaw('fuel_tank_teras.*, fuel_tanks.name AS fuel_tank')
                ->join('fuel_tanks', 'fuel_tanks.id', '=', 'fuel_tank_teras.fuel_tank_id')
                ->when($request->searchPhrase, function($query) use ($request) {
                    return $query->where('fuel_tanks.name', 'LIKE', '%'.$request->searchPhrase.'%')
                        ->orWhere('depth', 'LIKE', '%'.$request->searchPhrase.'%')
                        ->orWhere('volume', 'LIKE', '%'.$request->searchPhrase.'%');
                })->orderBy($sort, $dir)->paginate($pageSize);

            return [
                'rowCount' => $fuelTankTera->perPage(),
                'total' => $fuelTankTera->total(),
                'current' => $fuelTankTera->currentPage(),
                'rows' => $fuelTankTera->items(),
            ];
        }

        return view('fuelTankTera.index', [
            'breadcrumbs' => [
                'plant/dashboard' => 'SM',
                '#' => 'Master Data',
                'fuelTankTera' => 'Fuel Tank Tera Table'
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FuelTankTeraRequest $request)
    {
        $this->authorize('create', FuelTankTera::class);
        return FuelTankTera::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(FuelTankTera $fuelTankTera)
    {
        $this->authorize('view', FuelTankTera::class);
        return $fuelTankTera;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(FuelTankTeraRequest $request, FuelTankTera $fuelTankTera)
    {
        $this->authorize('update', FuelTankTera::class);
        $fuelTankTera->update($request->all());
        return $fuelTankTera;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(FuelTankTera $fuelTankTera)
    {
        $this->authorize('delete', FuelTankTera::class);
        return ['success' => $fuelTankTera->delete()];
    }
}
