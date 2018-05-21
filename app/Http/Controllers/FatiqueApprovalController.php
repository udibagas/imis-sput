<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Prajob;
use Carbon\Carbon;

class FatiqueApprovalController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax())
        {
            return Prajob::selectRaw('
                    prajobs.*,
                    prajobs.approval_status AS status,
                    employees.name AS name,
                    employees.nrp AS nrp
                ')
                ->where('prajobs.tgl', date('Y-m-d'))
                ->join('employees', 'employees.id', '=', 'prajobs.employee_id')
                ->orderBy('prajobs.tgl', 'DESC')->get();
        }

        return view('fatiqueApproval.index', [
            'breadcrumbs' => [
                'hcgs' => 'HCGS',
                '#' => 'Fatique Approval',
            ]
        ]);
    }

    public function update(Prajob $prajob, Request $request)
    {
        $input = $request->all();
        $input['approval_by'] = auth()->user()->id;
        $input['approval_date'] = Carbon::now();
        $prajob->update($input);
        return $prajob;
    }
}
