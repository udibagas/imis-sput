<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Pitstop;

class PitstopExport implements FromQuery, WithHeadings
{
    public $request = false;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function headings(): array
    {
        return [
            'Location',
            'Unit',
            'Unit Category',
            'Shift',
            'Time In',
            'Time Out',
            'Duration',
            'Description',
            'HM',
            'Status'
        ];
    }


    public function query()
    {
        $request = $this->request;

        return Pitstop::selectRaw('
                locations.name AS location,
                units.name AS unit,
                unit_categories.name AS unit_category,
                pitstops.shift AS shift,
                pitstops.time_in AS time_in,
                pitstops.time_out AS time_out,
                NULL AS duration,
                pitstops.description AS description,
                pitstops.hm AS hm,
                pitstops.status AS status
            ')
            ->join('units', 'units.id', '=', 'pitstops.unit_id')
            ->join('unit_categories', 'unit_categories.id', '=', 'units.unit_category_id')
            ->join('locations', 'locations.id', '=', 'pitstops.location_id')
            ->when($request, function($query) use ($request) {
                return $query->whereRaw("DATE(pitstops.time_in) BETWEEN '{$request->from}' AND '{$request->to}'");
            })
            ->orderBy('time_in', 'DESC');
    }
}
