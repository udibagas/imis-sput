<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\PortActivity;

class PortActivityExport implements FromQuery, WithHeadings
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
            'Shift',
            'Time Start',
            'Time End',
            'Activity',
            'Unit',
            'Hauler',
            'Block Area',
            'Stock Area',
            'Jetty',
            'Hopper',
            'Bucket',
            'Volume',
            'Material Type',
            'Seam',
            'Customer',
            'Contractor',
            'Employee',
            'User'
        ];
    }


    public function query()
    {
        $request = $this->request;

        return PortActivity::selectRaw('
                port_activities.date AS date,
                port_activities.shift AS shift,
                port_activities.time_start AS time_start,
                port_activities.time_end AS time_end,
                CASE
                    WHEN port_activities.unit_activity_id = 1 THEN "Hauling"
                    WHEN port_activities.unit_activity_id = 2 THEN "Feeding"
                    WHEN port_activities.unit_activity_id = 3 THEN "Load and Carry"
                    WHEN port_activities.unit_activity_id = 4 THEN "Loading"
                    WHEN port_activities.unit_activity_id = 5 THEN "Stock Piling"
                    WHEN port_activities.unit_activity_id = 6 THEN "Breakdown"
                    WHEN port_activities.unit_activity_id = 7 THEN "Standby"
                END,
                units.name AS unit,
                haulers.name AS hauler,
                areas.name AS area,
                stock_areas.name AS stock_area,
                jetties.name AS jetty,
                hoppers.name AS hpr,
                port_activities.rit AS rit,
                port_activities.volume AS volume,
                IF(material_stocks.material_type = "l", "LOW", "HIGH"),
                seams.name AS seam,
                customers.name AS customer,
                contractors.name AS contractor,
                employees.name AS employee,
                users.name AS user
            ')
            ->join('units', 'units.id', '=', 'port_activities.unit_id')
            ->join('units AS haulers', 'haulers.id', '=', 'port_activities.hauler_id', 'LEFT')
            ->join('material_stocks', 'material_stocks.id', '=', 'port_activities.material_stock_id', 'LEFT')
            ->join('stock_areas', 'stock_areas.id', '=', 'material_stocks.stock_area_id', 'LEFT')
            ->join('areas', 'areas.id', '=', 'stock_areas.area_id', 'LEFT')
            ->join('employees', 'employees.id', '=', 'port_activities.employee_id')
            ->join('customers', 'customers.id', '=', 'material_stocks.customer_id', 'LEFT')
            ->join('contractors', 'contractors.id', '=', 'material_stocks.contractor_id', 'LEFT')
            ->join('seams', 'seams.id', '=', 'material_stocks.seam_id', 'LEFT')
            ->join('hoppers', 'hoppers.id', '=', 'port_activities.hopper_id', 'LEFT')
            ->join('jetties', 'jetties.id', '=', 'hoppers.jetty_id', 'LEFT')
            ->join('users', 'users.id', '=', 'port_activities.user_id', 'LEFT')
            ->when($request, function($query) use ($request) {
                return $query->whereRaw("`date` BETWEEN '{$request->from}' AND '{$request->to}'");
            })
            ->orderBy('port_activities.id', 'DESC');
    }
}
