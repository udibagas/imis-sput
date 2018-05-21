<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Egi;
use App\FuelTank;
use DB;

class SmController extends Controller
{
    public function index(Request $request)
    {
        return view('sm.index', [
            'egi'=> Egi::orderBy('name', 'ASC')->get(),
            'breadcrumbs' => [
                'sm' => 'SM',
                '#' => 'Dashboard'
            ]
        ]);
    }

    public function fuelStock()
    {
        return FuelTank::orderBy('name', 'ASC')->get();
    }

    public function fuelConsumption(Request $request)
    {
        $sql = "SELECT
                SUM(f.total_real) AS total_real,
                SUM(f.hm - f.hm_last) AS total_hm,
                e.name AS egi
            FROM fuel_refills f
            JOIN units u ON u.id = f.unit_id
            JOIN egis e ON e.id = u.egi_id
            WHERE f.date BETWEEN '$request->start' AND '$request->end'
            GROUP BY e.name
            ORDER BY e.name ASC";

        return DB::select(DB::raw($sql));
    }

    public function fuelRatio(Request $request)
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
