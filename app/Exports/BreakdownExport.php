<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Breakdown;

class BreakdownExport implements FromQuery, WithHeadings
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
            'B/D Status',
            'Location',
            'KM',
            'HM',
            'Time In',
            'Time Out',
            'Problem',
            'Component Criteria',
            'Action',
            'WO Number',
            'Status'
        ];
    }

    public function query()
    {
        $request = $this->request;

        return Breakdown::selectRaw('
                units.name AS unit,
                unit_categories.name AS unit_category,
                CONCAT(breakdown_categories.name, " - ", breakdown_categories.description_en) AS breakdown_category,
                breakdown_statuses.code AS breakdown_status,
                locations.name AS location,
                breakdowns.km AS km,
                breakdowns.hm AS hm,
                breakdowns.time_in AS time_in,
                breakdowns.time_out AS time_out,
                breakdowns.diagnosa AS diagnosa,
                CONCAT(component_criterias.code, " - ", component_criterias.description) AS component_criteria,
                breakdowns.tindakan AS action,
                breakdowns.wo_number AS wo_number,
                breakdowns.status AS status
            ')
            ->join('units', 'units.id', '=', 'breakdowns.unit_id')
            ->join('unit_categories', 'unit_categories.id', '=', 'units.unit_category_id')
            ->join('locations', 'locations.id', '=', 'breakdowns.location_id')
            ->join('breakdown_categories', 'breakdown_categories.id', '=', 'breakdowns.breakdown_category_id')
            ->join('breakdown_statuses', 'breakdown_statuses.id', '=', 'breakdowns.breakdown_status_id', 'LEFT')
            ->join('component_criterias', 'component_criterias.id', '=', 'breakdowns.component_criteria_id', 'LEFT')
            ->when($request, function($query) use ($request) {
                return $query->whereRaw("DATE(breakdowns.time_in) BETWEEN '{$request->from}' AND '{$request->to}'");
            })
            ->orderBy('time_in', 'DESC');
    }
}
