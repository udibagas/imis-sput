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
                positions.name AS position
            ')
            ->join('departments', 'departments.id', '=', 'employees.department_id')
            ->join('offices', 'offices.id', '=', 'employees.office_id', 'LEFT')
            ->join('owners', 'owners.id', '=', 'employees.owner_id', 'LEFT')
            ->join('positions', 'positions.id', '=', 'employees.position_id')
            ->orderBy('name', 'ASC')->get();

        return view('employee.export', [
            'employees' => $employees
        ]);
    }
}
