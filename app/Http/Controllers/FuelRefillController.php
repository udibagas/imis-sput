<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\FuelRefill;
use App\Unit;
use App\Http\Requests\FuelRefillRequest;
use Carbon\Carbon;

class FuelRefillController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view', FuelRefill::class);

        if ($request->ajax())
        {
            $pageSize = $request->rowCount > 0 ? $request->rowCount : 1000000;
            $request['page'] = $request->current;
            $sort = $request->sort ? key($request->sort) : 'fuel_refills.date';
            $dir = $request->sort ? $request->sort[$sort] : 'DESC';

            $fuelRefill = FuelRefill::selectRaw('
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
                'rowCount' => $fuelRefill->perPage(),
                'total' => $fuelRefill->total(),
                'current' => $fuelRefill->currentPage(),
                'rows' => $fuelRefill->items(),
            ];
        }

        return view('fuelRefill.index', [
            'breadcrumbs' => [
                'sm/dashboard' => 'SM',
                'fuelRefill' => 'Fuel Refill'
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FuelRefillRequest $request)
    {
        $this->authorize('create', FuelRefill::class);
        $input = $request->all();
        $input['user_id'] = auth()->user()->id;
        $fuelRefill = FuelRefill::create($input);

        $fuelRefill->fuelTank->update([
            'stock' => $fuelRefill->fuelTank->stock - $request->total_real,
            'last_stock_time' => Carbon::now()
        ]);

        return $fuelRefill;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(FuelRefill $fuelRefill)
    {
        $this->authorize('view', FuelRefill::class);
        return $fuelRefill;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(FuelRefillRequest $request, FuelRefill $fuelRefill)
    {
        $this->authorize('update', FuelRefill::class);
        // hitung selisih total_real awal & akhir;
        $selisih = $request->total_real - $fuelRefill->total_real;
        $fuelRefill->update($request->all());

        $fuelRefill->fuelTank->update([
            'stock' => $fuelRefill->fuelTank->stock - $selisih,
            'last_stock_time' => Carbon::now()
        ]);

        return $fuelRefill;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(FuelRefill $fuelRefill)
    {
        $this->authorize('delete', FuelRefill::class);

        $fuelRefill->fuelTank->update([
            'stock' => $fuelRefill->fuelTank->stock + $fuelRefill->total_real,
            'last_stock_time' => Carbon::now()
        ]);

        return ['success' => $fuelRefill->delete()];
    }

    public function getLastRefill(Unit $unit)
    {
        return FuelRefill::where('unit_id', $unit->id)->latest()->first();
    }
}
