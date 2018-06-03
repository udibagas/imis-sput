<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\DormitoryReservation;

class DormitoryReservationExport implements FromQuery, WithHeadings
{
    public $request = false;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function headings(): array
    {
        return [
            'Permit Number',
            'NRP',
            'Name',
            'Department',
            'Position',
            'Dormitory',
            'Room',
            'Need',
            'Check In',
            'Check Out',
            'Cuti',
            'Status'
        ];
    }

    public function query()
    {
        $request = $this->request;

        return DormitoryReservation::selectRaw('
                dormitory_reservations.permit_number AS permit_number,
                employees.nrp AS nrp,
                employees.name AS name,
                departments.name AS department,
                positions.name AS position,
                dormitories.name AS dormitory,
                dormitory_rooms.name AS room,
                dormitory_reservations.need AS need,
                dormitory_reservations.check_in AS check_in,
                dormitory_reservations.check_out AS check_out
            ')
            ->join('employees', 'employees.id', '=', 'dormitory_reservations.employee_id')
            ->join('departments', 'departments.id', '=', 'employees.department_id')
            ->join('positions', 'positions.id', '=', 'employees.position_id')
            ->join('dormitory_rooms', 'dormitory_rooms.id', '=', 'dormitory_reservations.dormitory_room_id')
            ->join('dormitories', 'dormitories.id', '=', 'dormitory_rooms.dormitory_id')
            ->when($request, function($query) use ($request) {
                return $query->whereRaw("dormitory_reservations.check_in BETWEEN '{$request->from}' AND '{$request->to}'");
            })->orderBy('dormitory_reservations.check_in', 'DESC');
    }
}
