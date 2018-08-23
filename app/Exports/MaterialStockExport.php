<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\MaterialStock;

class MaterialStockExport implements FromQuery, WithHeadings
{
    public function headings(): array
    {
        return [
            'Dumping Date',
            'Material Type',
            'Seam',
            'Customer',
            'Contractor',
            'Block Area',
            'Stock Area',
            'Volume',
            'Age',
        ];
    }


    public function query()
    {
        return MaterialStock::selectRaw('
                material_stocks.dumping_date AS dumping_date,
                IF(material_stocks.material_type = "l", "LOW", "HIGH"),
                seams.name AS seam,
                customers.name AS customer,
                contractors.name AS contractor,
                areas.name AS area,
                stock_areas.name AS stock_area,
                material_stocks.volume AS volume
            ')
            ->join('stock_areas', 'stock_areas.id', '=', 'material_stocks.stock_area_id')
            ->join('areas', 'areas.id', '=', 'stock_areas.area_id')
            ->join('customers', 'customers.id', '=', 'material_stocks.customer_id')
            ->join('contractors', 'contractors.id', '=', 'material_stocks.contractor_id')
            ->join('seams', 'seams.id', '=', 'material_stocks.seam_id', 'LEFT')
            ->when(auth()->user()->customer_id, function($query) {
                return $query->where('material_stocks.customer_id', auth()->user()->customer_id);
            })
            ->when(auth()->user()->contractor_id, function($query) {
                return $query->where('material_stocks.contractor_id', auth()->user()->contractor_id);
            })
            ->orderBy('material_stocks.dumping_date', 'DESC');
    }
}
