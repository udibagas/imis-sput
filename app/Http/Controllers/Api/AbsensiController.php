<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Absensi;
use App\Prajob;
use App\Employee;

class AbsensiController extends Controller
{
    public function store(Request $request)
    {
        $employee = Employee::where('nrp', 'LIKE', $request->nrp)->first();

        if (!$employee) {
            return ['status' => false, 'message' => 'Employee not found'];
        }

        // out shift 2 di tanggal selanjutnya
        if ($request->in_out_code == '2' && $request->shift == '2') {
            $absensi = Absensi::where('employee_id', $employee->id)
                ->whereRaw('DATEDIFF("'.$request->tgl.'", `tgl`) = 1')
                ->where('shift', $request->shift)
                ->first();
        } else {
            $absensi = Absensi::where('employee_id', $employee->id)
            ->where('date', $request->tgl)
            ->where('shift', $request->shift)
            ->first();
        }

        // berarti sudah absen, update in atau out
        if ($absensi)
        {
            if ($request->in_out_code == '1' && !$absensi->in) {
                $absensi->update(['in' => $request->tgl. ' '.$request->time]);
                return ['status' => true, 'message' => 'Absen masuk untuk '. $employee->name. ' berhasil'];
            }

            if ($request->in_out_code == '2' && !$absensi->out) {
                $absensi->update(['out' => $request->tgl. ' '.$request->time]);
                return ['status' => true, 'message' => 'Absen pulang untuk '. $employee->name. ' berhasil'];
            }

            return ['status' => true, 'message' => $employee->name .' sudah absen'];
        }

        try {
            $absensi = Absensi::create([
                'employee_id' => $employee->id,
                'date' => $request->tgl,
                'shift' => $request->shift,
                'in' => $request->in_out_code == '1' ? $request->tgl. ' '. $request->time : NULL,
                'out' => $request->in_out_code == '2' ? $request->tgl. ' '. $request->time : NULL,
                'zona_no' => $request->zona_no,
                'terminal_no' => $request->terminal_no
            ]);
        } catch (\Exception $e) {
            return ['status' => false, 'message' => 'Failed to insert data absensi '. $e->getMessage()];
        }

        $dataFatique = $request->all();
        $dataFatique['employee_id'] = $employee->id;
        $dataFatique['minum_obat'] = $request->minum_obat == 'Y' ? 1 : 0;
        $dataFatique['ada_masalah'] = $request->ada_masalah == 'Y' ? 1 : 0;
        $dataFatique['siap_bekerja'] = $request->siap_bekerja == 'Y' ? 1 : 0;

        try {
            $prajob = Prajob::create($dataFatique);
        } catch (\Exception $e) {
            return ['status' => false, 'message' => 'Failed to insert data fatique '. $e->getMessage()];
        }

        return ['status' => true, 'message' => 'Absen masuk & fatique check untuk '. $employee->name. ' berhasil'];
    }
}
