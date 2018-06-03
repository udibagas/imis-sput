<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\Employee;

class EmployeeExport implements FromView
{
    public function view() : View
    {
        $employees = Employee::selectRaw('
                employees.*,
                departments.name AS department,
                offices.name AS office,
                owners.name AS owner,
                positions.name AS position,
                dormitory_rooms.name AS room,
                dormitories.name AS dormitory
            ')
            ->join('departments', 'departments.id', '=', 'employees.department_id')
            ->join('offices', 'offices.id', '=', 'employees.office_id', 'LEFT')
            ->join('owners', 'owners.id', '=', 'employees.owner_id', 'LEFT')
            ->join('positions', 'positions.id', '=', 'employees.position_id')
            ->join('dormitory_rooms', 'dormitory_rooms.id', '=', 'employees.dormitory_room_id', 'LEFT')
            ->join('dormitories', 'dormitories.id', '=', 'dormitory_rooms.dormitory_id', 'LEFT')
            ->orderBy('employees.name', 'ASC')->get();

        return view('employee.export', [
            'employees' => $employees
        ]);
    }
}
