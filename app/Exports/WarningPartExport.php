<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\WarningPart;

class WarningPartExport implements FromQuery, WithHeadings
{
    public $request = false;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function headings(): array
    {
        return [
            'Unit',
            'Unit Category',
            'B/D TYPE',
            'Location',
            'Warning Part',
            'Time In',
            'Note',
            'Status'
        ];
    }


    public function query()
    {
        $request = $this->request;

        return WarningPart::selectRaw('
                units.name AS unit,
                unit_categories.name AS unit_category,
                CONCAT(breakdown_categories.name, " - ", breakdown_categories.description_en) AS breakdown_category,
                locations.name AS location,
                breakdowns.warning_part AS warning_part,
                breakdowns.time_in AS time_in,
                warning_parts.note AS note,
                warning_parts.status AS status
            ')
            ->join('breakdowns', 'breakdowns.id', '=', 'warning_parts.breakdown_id')
            ->join('units', 'units.id', '=', 'breakdowns.unit_id')
            ->join('breakdown_categories', 'breakdown_categories.id', '=', 'breakdowns.breakdown_category_id')
            ->join('locations', 'locations.id', '=', 'breakdowns.location_id')
            ->join('unit_categories', 'unit_categories.id', '=', 'units.unit_category_id')
            ->join('breakdown_statuses', 'breakdown_statuses.id', '=', 'breakdowns.breakdown_status_id', 'LEFT')
            ->join('users', 'users.id', '=', 'warning_parts.user_id', 'LEFT')

            ->when($request, function($query) use ($request) {
                return $query->whereRaw("DATE(breakdowns.time_in) BETWEEN '{$request->from}' AND '{$request->to}'");
            })
            ->orderBy('warning_parts.id', 'DESC');
    }
}
