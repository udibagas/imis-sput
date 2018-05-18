<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Unit;

class UnitExport implements FromQuery, WithHeadings
{
    public function headings(): array
    {
        return [
            'Name',
            'Category',
            'Owner',
            'EGI',
            'FC'
        ];
    }

    public function query()
    {
        return Unit::selectRaw('
                units.name AS name,
                unit_categories.name AS category,
                owners.name AS owner,
                egis.name AS egi,
                egis.fc AS fc
            ')
            ->join('owners', 'owners.id', '=', 'units.owner_id')
            ->join('egis', 'egis.id', '=', 'units.egi_id')
            ->join('unit_categories', 'unit_categories.id', '=', 'units.unit_category_id', 'LEFT')
            ->orderBy('units.name', 'ASC');
    }
}
