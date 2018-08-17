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
            'Subcont',
            'Unit',
            'Block Area',
            'Stock Area',
            'Material Type',
            'Seam',
            'Volume',
            'Customer',
            'Register Number',
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
                subconts.name AS subcont,
                subcont_units.code_number AS unit,
                areas.name AS area,
                stock_areas.name AS stock_area,
                IF(stock_dumpings.material_type = "l", "LOW", "HIGH"),
                seams.name AS seam,
                stock_dumpings.volume,
                customers.name AS customer,
                stock_dumpings.register_number AS register_number,
                users.name AS user,
                stock_dumpings.insert_via
            ')
            ->join('subcont_units', 'subcont_units.id', '=', 'stock_dumpings.subcont_unit_id')
            ->join('subconts', 'subconts.id', '=', 'subcont_units.subcont_id')
            ->join('stock_areas', 'stock_areas.id', '=', 'stock_dumpings.stock_area_id')
            ->join('areas', 'areas.id', '=', 'stock_areas.area_id')
            ->join('customers', 'customers.id', '=', 'stock_dumpings.customer_id')
            ->join('users', 'users.id', '=', 'stock_dumpings.user_id')
            ->join('seams', 'seams.id', '=', 'stock_dumpings.seam_id', 'LEFT')
            ->when($request, function($query) use ($request) {
                return $query->whereRaw("`date` BETWEEN '{$request->from}' AND '{$request->to}'");
            })
            ->orderBy('stock_dumpings.id', 'DESC');
    }
}
