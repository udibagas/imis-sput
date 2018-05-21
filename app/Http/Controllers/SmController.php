<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Egi;
use App\FuelTank;

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

    public function literPerHm(Request $request)
    {
        return [];
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
