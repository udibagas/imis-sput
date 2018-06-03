<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Employee;

class EmployeeExportQuery implements FromQuery, WithHeadings
{
    public $request = false;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function headings(): array
    {
        return [
            'NRP',
            'Name',
            'Department',
            'Position',
            'Office',
            'Owner',
            'Dormitory',
            'Room'
        ];
    }

    public function query()
    {
        $request = $this->request;

        return Employee::selectRaw('
                employees.nrp AS nrp,
                employees.name AS name,
                departments.name AS department,
                positions.name AS position,
                offices.name AS office,
                owners.name AS owner,
                dormitories.name AS dormitory,
                dormitory_rooms.name AS room
            ')
            ->when($request, function($query) use ($request) {
                return $query->where('employees.name', 'LIKE', "%{$request->q}%");
            })
            ->join('departments', 'departments.id', '=', 'employees.department_id')
            ->join('offices', 'offices.id', '=', 'employees.office_id', 'LEFT')
            ->join('owners', 'owners.id', '=', 'employees.owner_id', 'LEFT')
            ->join('positions', 'positions.id', '=', 'employees.position_id')
            ->join('dormitory_rooms', 'dormitory_rooms.id', '=', 'employees.dormitory_room_id', 'LEFT')
            ->join('dormitories', 'dormitories.id', '=', 'dormitory_rooms.dormitory_id', 'LEFT')
            ->orderBy('employees.name', 'ASC');
    }
}
