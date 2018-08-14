<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\FuelRefill;
use Carbon\Carbon;

class FuelRefillController extends Controller
{
    public function index(Request $request)
    {
        return FuelRefill::selectRaw('
                fuel_refills.*, units.name AS unit,
                employees.name AS operator
            ')
            ->join('units', 'units.id', '=', 'fuel_refills.unit_id')
            ->join('employees', 'employees.id', '=', 'fuel_refills.employee_id')
            ->when($request->fuel_tank_id, function($query) use ($request) {
                return $query->where('fuel_tank_id', $request->fuel_tank_id);
            })->when($request->date, function($query) use ($request) {
                return $query->where('date', $request->date);
            })->orderBy('id', 'DESC')->limit(100)->get();
    }

    public function store(Request $request)
    {
        $rows   = json_decode($request->rows);
        $ids    = [];

        foreach($rows as $r)
        {
            $ids[] = $r->id;

            $data = [
                'date'              => $r->date,
                'shift'             => $r->shift,
                'fuel_tank_id'		=> $r->fuel_tank_id,
                'unit_id'           => $r->unit_id,
                'employee_id'       => $r->employee_id,
                'start_time'        => $r->start_time,
                'finish_time'       => $r->finish_time,
                'hm'                => $r->hm,
                'km'                => $r->km,
                'hm_last'           => $r->hm_last ? $r->hm_last : 0,
                'km_last'           => $r->km_last ? $r->km_last : 0,
                'total_real'        => $r->total_real,
                'total_recommended' => $r->total_recommended ? $r->total_recommended : 0,
                'user_id'      	    => $r->user_id,
                'insert_via'        => 'mobile'
            ];

            // check duplikasi
            $exists = FuelRefill::where('date', $r->date)
                ->where('shift', $r->shift)
                ->where('fuel_tank_id', $r->fuel_tank_id)
                ->where('unit_id', $r->unit_id)
                ->where('employee_id', $r->employee_id)
                ->where('km', $r->km)
                ->first();

            if ($exists) {
                continue;
            }

            $fuelRefill = FuelRefill::create($data);

            // update stock fuel tank
            $fuelRefill->fuelTank->update([
                'stock' => $fuelRefill->fuelTank->stock - $fuelRefill->total_real,
                'last_stock_time' => Carbon::now()
            ]);
        }

        $ret = (count($ids) > 0)
            ? ['ids' => implode(',', $ids), 'success' => true]
            : ['success' => false];

        return json_encode($ret);
    }
}
