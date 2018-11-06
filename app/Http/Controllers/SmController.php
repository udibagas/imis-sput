<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Egi;
use App\FuelTank;
use App\FuelRefill;
use DB;
use Carbon\Carbon;

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

    public function fuelRatio1(Request $request)
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

    public function fuelRatio(Request $request)
    {
        if ($request->ajax())
        {
            $jam = [7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,0,1,2,3,4,5,6];
            $date = $request->date ? $request->date : date('Y-m-d');
            $literPerTon = [];

            foreach ($jam as $j)
            {
                // $date = ($j < 7) ? $nextDay : $today;

                $liter = DB::select('SELECT SUM(total_real) AS liter FROM fuel_refills WHERE HOUR(finish_time) = :hour AND `date` = :dt', [':hour' => $j, ':dt' => $date])[0]->liter;

                $ton = DB::select('SELECT SUM(volume)/1000 AS ton FROM port_activities WHERE HOUR(time_end) = :hour AND `date` = :dt', [':hour' => $j, ':dt' => $date])[0]->ton;

                try {
                    $literPerTon[] = $liter/$ton;
                } catch (\Exception $e) {
                    $literPerTon[] = null;
                }
            }

            return $literPerTon;
        }
    }
}
