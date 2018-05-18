<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Absensi;

class AbsensiExport implements FromQuery, WithHeadings
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
            'NRP',
            'Name',
            'Department',
            'Position',
            'Shift',
            'IN',
            'OUT'
        ];
    }

    public function query()
    {
        $request = $this->request;

        return Absensi::selectRaw('
                DATE(absensis.in) AS date,
                employees.nrp AS nrp,
                employees.name AS name,
                departments.name AS department,
                positions.name AS position,
                IF(HOUR(absensis.in) >= 7 AND HOUR(absensis.in) < 19, 1, 2) AS shift,
                absensis.in,
                absensis.out
            ')
            ->join('employees', 'employees.id', '=', 'absensis.employee_id')
            ->join('departments', 'departments.id', '=', 'employees.department_id')
            ->join('offices', 'offices.id', '=', 'employees.office_id', 'LEFT')
            ->join('owners', 'owners.id', '=', 'employees.owner_id', 'LEFT')
            ->join('positions', 'positions.id', '=', 'employees.position_id')
            ->when($request, function($query) use ($request) {
                return $query->whereRaw("DATE(absensis.in) BETWEEN '{$request->from}' AND '{$request->to}'");
            })
            ->orderBy('in', 'DESC');
    }
}
