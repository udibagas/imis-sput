<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Prajob;

class PrajobExport implements FromQuery, WithHeadings
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
            'Shift',
            'NRP',
            'Name',
            'Jam Tidur',
            'Jam Bangun',
            'Minum Obat',
            'Ada Masalah',
            'Siap Bekerja',
            'Status Persetujuan',
        ];
    }

    public function query()
    {
        $request = $this->request;

        return Prajob::selectRaw('
                prajobs.tgl AS tgl,
                prajobs.shift AS shift,
                employees.nrp AS nrp,
                employees.name AS name,
                prajobs.jam_tidur AS jam_tidur,
                prajobs.jam_bangun AS jam_bangun,
                prajobs.minum_obat AS minum_obat,
                prajobs.ada_masalah AS ada_masalah,
                prajobs.siap_bekerja AS siap_bekerja,
                prajobs.approval_status AS approval_status
            ')
            ->join('employees', 'employees.id', '=', 'prajobs.employee_id')
            // ->join('departments', 'departments.id', '=', 'employees.department_id')
            // ->join('offices', 'offices.id', '=', 'employees.office_id', 'LEFT')
            // ->join('owners', 'owners.id', '=', 'employees.owner_id', 'LEFT')
            // ->join('positions', 'positions.id', '=', 'employees.position_id')
            ->when($request, function($query) use ($request) {
                return $query->whereRaw("prajobs.tgl BETWEEN '{$request->from}' AND '{$request->to}'");
            })
            ->orderBy('prajobs.tgl', 'DESC');
    }
}
