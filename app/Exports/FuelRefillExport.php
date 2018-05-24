<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\FuelRefill;

class FuelRefillExport implements FromQuery, WithHeadings
{
    public $request = false;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function headings(): array
    {
        return [
            'Date',
            'Fuel Tank',
            'Unit',
            'Unit Category',
            'Shift',
            'Qty',
            'KM',
            'HM',
            'KM Last',
            'HM Last',
            'NRP',
            'Employee Name',
            'FC',
            'FC Real',
            'Start Time',
            'Finish Time',
            'Duration',
            'Insert By',
        ];
    }


    public function query()
    {
        $request = $this->request;

        return FuelRefill::selectRaw('
                fuel_refills.date AS date,
                fuel_tanks.name AS fuel_tank,
                units.name AS unit,
                unit_categories.name AS unit_category,
                fuel_refills.shift AS shift,
                fuel_refills.total_real AS total_real,
                fuel_refills.km AS km,
                fuel_refills.hm AS hm,
                fuel_refills.km_last AS km_last,
                fuel_refills.hm_last AS hm_last,
                employees.nrp AS nrp,
                employees.name AS employee_name,
                egis.fc AS fc,
                IF(fuel_refills.hm_last, fuel_refills.total_real / (fuel_refills.hm - fuel_refills.hm_last), 0) AS fc_real,
                fuel_refills.start_time AS start_time,
                fuel_refills.finish_time AS finish_time,
                TIMEDIFF(fuel_refills.finish_time, fuel_refills.start_time) AS duration,
                users.name AS insert_by
            ')
            ->join('units', 'units.id', '=', 'fuel_refills.unit_id')
            ->join('egis', 'egis.id', '=', 'units.egi_id')
            ->join('fuel_tanks', 'fuel_tanks.id', '=', 'fuel_refills.fuel_tank_id')
            ->join('employees', 'employees.id', '=', 'fuel_refills.employee_id')
            ->join('users', 'users.id', '=', 'fuel_refills.user_id')
            ->join('unit_categories', 'unit_categories.id', '=', 'units.unit_category_id')
            ->when($request, function($query) use ($request) {
                return $query->whereRaw("`date` BETWEEN '{$request->from}' AND '{$request->to}'");
            })
            ->orderBy('fuel_refills.date', 'DESC');
    }
}
