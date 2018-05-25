<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Egi;
use App\FuelTank;
use App\FuelRefill;

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
        $date = $request->date ? $request->date : date('Y-m-d');
        $firstDate = date('Y-m-01', strtotime($date));

        $fc = FuelRefill::getFc($date, $date);
        $fcMonth = FuelRefill::getFc($firstDate, $date);

        $data = [];

        foreach ($fcMonth as $i => $f)
        {
            $data[] = [
                'egi' => $f->egi,
                'fc_standard' => $f->fc_standard,
                'fc_month' => $f->fc,
                'fc' => isset($fc[$i]) ? $fc[$i]->fc : 0
            ];
        }

        return json_encode($data);
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
