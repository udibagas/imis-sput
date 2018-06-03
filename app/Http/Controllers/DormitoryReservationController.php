<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DormitoryReservation;
use App\Http\Requests\DormitoryReservationRequest;
use App\Exports\DormitoryReservationExport;
use Excel;

class DormitoryReservationController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('view', DormitoryReservation::class);

        if ($request->ajax())
        {
            $pageSize = $request->rowCount > 0 ? $request->rowCount : 1000000;
            $request['page'] = $request->current;
            $sort = $request->sort ? key($request->sort) : 'dormitory_reservations.check_out';
            $dir = $request->sort ? $request->sort[$sort] : 'DESC';

            $absensi = DormitoryReservation::selectRaw('
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
                ->when($request->searchPhrase, function($query) use ($request) {
                    return $query->where('employees.name', 'LIKE', '%'.$request->searchPhrase.'%')
                        ->orWhere('employees.nrp', 'LIKE', '%'.$request->searchPhrase.'%')
                        ->orWhere('departments.name', 'LIKE', '%'.$request->searchPhrase.'%')
                        ->orWhere('positions.name', 'LIKE', '%'.$request->searchPhrase.'%')
                        ->orWhere('dormitory_reservations.permit_number', 'LIKE', '%'.$request->searchPhrase.'%');
                })->orderBy($sort, $dir)->paginate($pageSize);

            return [
                'rowCount' => $absensi->perPage(),
                'total' => $absensi->total(),
                'current' => $absensi->currentPage(),
                'rows' => $absensi->items(),
            ];
        }

        return view('dormitoryReservation.index', [
            'breadcrumbs' => [
                'hcgs' => 'HCGS',
                'dormitoryReservation' => 'Dormitory Management'
            ]
        ]);
    }

    public function show(DormitoryReservation $dormitoryReservation)
    {
        $this->authorize('view', DormitoryReservation::class);
        return $dormitoryReservation;
    }

    public function store(DormitoryReservationRequest $request)
    {
        $this->authorize('create', DormitoryReservation::class);
        $dormitoryReservation = DormitoryReservation::create($request->all());

        $dormitoryReservation->employee()->update([
            'dormitory_room_id' => $request->dormitory_room_id
        ]);

        return $dormitoryReservation;
    }

    public function update(DormitoryReservationRequest $request, DormitoryReservation $dormitoryReservation)
    {
        $this->authorize('update', DormitoryReservation::class);
        $dormitoryReservation->update($request->all());

        if ($dormitoryReservation->is_checked_out)
        {
            $dormitoryReservation->employee()->update([
                'dormitory_room_id' => NULL
            ]);
        }

        else {
            $dormitoryReservation->employee()->update([
                'dormitory_room_id' => $request->dormitory_room_id
            ]);
        }

        return $dormitoryReservation;
    }

    public function destroy(DormitoryReservation $dormitoryReservation)
    {
        $this->authorize('delete', DormitoryReservation::class);

        $dormitoryReservation->employee()->update([
            'dormitory_room_id' => NULL
        ]);

        return ['success' => $dormitoryReservation->delete()];
    }

    public function export(Request $request)
    {
        $this->authorize('export', DormitoryReservation::class);
        return Excel::download(new DormitoryReservationExport($request), "dormitory-reservations-{$request->from}-to-{$request->to}.xlsx");
    }

    public function lewatMasaCuti()
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
            ->where('is_checked_out', 0)
            ->whereRaw('DATEDIFF(DATE(NOW()), check_out) >= -3')
            ->orderBy('check_out', 'ASC')
            ->get();
    }

}
