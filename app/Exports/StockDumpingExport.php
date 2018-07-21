<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\StockDumping;

class StockDumpingExport implements FromQuery, WithHeadings
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
            'Time',
            'Unit',
            'Material Type',
            'Seam',
            'Area',
            'Volume',
            'Customer',
            'Employee',
            'User',
            'Insert Via',
        ];
    }


    public function query()
    {
        $request = $this->request;

        return StockDumping::selectRaw('
                stock_dumpings.date,
                stock_dumpings.shift,
                stock_dumpings.time,
                units.name AS unit,
                stock_dumpings.material_type,
                seams.name AS seam,
                CONCAT("Jetty ", jetties.name, " - ", stock_areas.name) AS area,
                stock_dumpings.volume,
                customers.name AS customer,
                employees.name AS employee,
                users.name AS user,
                stock_dumpings.insert_via
            ')
            ->join('units', 'units.id', '=', 'stock_dumpings.unit_id')
            ->join('stock_areas', 'stock_areas.id', '=', 'stock_dumpings.stock_area_id')
            ->join('jetties', 'jetties.id', '=', 'stock_areas.jetty_id')
            ->join('employees', 'employees.id', '=', 'stock_dumpings.employee_id')
            ->join('customers', 'customers.id', '=', 'stock_dumpings.customer_id')
            ->join('users', 'users.id', '=', 'stock_dumpings.user_id')
            ->join('seams', 'seams.id', '=', 'stock_dumpings.seam_id', 'LEFT')
            ->when($request, function($query) use ($request) {
                return $query->whereRaw("`date` BETWEEN '{$request->from}' AND '{$request->to}'");
            })
            ->orderBy('stock_dumpings.date', 'DESC');
    }
}
