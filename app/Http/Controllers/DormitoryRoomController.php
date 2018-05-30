<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DormitoryRoom;
use App\DormitoryReservation;

class DormitoryRoomController extends Controller
{
    public function show(DormitoryRoom $dormitoryRoom)
    {
        return $dormitoryRoom;
    }

    public function destroy(DormitoryRoom $dormitoryRoom)
    {
        $dormitoryRoom->reservations()->delete();
        return ['success' => $dormitoryRoom->delete()];
    }

    public function getCurrentReservation(DormitoryRoom $dormitoryRoom)
    {
        return DormitoryReservation::selectRaw('
                dormitory_reservations.*,
                employees.name AS name,
                dormitories.name AS dormitory,
                dormitory_rooms.name AS room,
                employees.nrp AS nrp,
                departments.name AS department,
                positions.name AS position
            ')
            ->join('employees', 'employees.id', '=', 'dormitory_reservations.employee_id')
            ->join('departments', 'departments.id', '=', 'employees.department_id')
            ->join('positions', 'positions.id', '=', 'employees.position_id')
            ->join('dormitory_rooms', 'dormitory_rooms.id', '=', 'dormitory_reservations.dormitory_room_id')
            ->join('dormitories', 'dormitories.id', '=', 'dormitory_rooms.dormitory_id')
            ->where('dormitory_room_id', $dormitoryRoom->id)
            ->whereRaw("((DATE(NOW()) BETWEEN check_in AND check_out AND is_checked_out = 0) OR is_checked_out = 0)")
            ->orderBy('employees.name', 'ASC')
            ->get();
    }
}
