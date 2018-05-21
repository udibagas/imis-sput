<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Absensi;
use App\Exports\AbsensiExport;
use App\Http\Requests\AbsensiRequest;
use Excel;

class AbsensiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view', Absensi::class);

        if ($request->ajax())
        {
            $pageSize = $request->rowCount > 0 ? $request->rowCount : 1000000;
            $request['page'] = $request->current;
            $sort = $request->sort ? key($request->sort) : 'absensis.in';
            $dir = $request->sort ? $request->sort[$sort] : 'desc';

            $absensi = Absensi::selectRaw('
                    absensis.*,
                    DATE(absensis.in) AS date,
                    IF(HOUR(absensis.in) >= 7 AND HOUR(absensis.in) < 19, 1, 2) AS shift,
                    employees.name AS name,
                    employees.nrp AS nrp,
                    departments.name AS department,
                    positions.name AS position
                ')
                ->join('employees', 'employees.id', '=', 'absensis.employee_id')
                ->join('departments', 'departments.id', '=', 'employees.department_id')
                ->join('positions', 'positions.id', '=', 'employees.position_id')
                ->when($request->searchPhrase, function($query) use ($request) {
                    return $query->where('employees.name', 'LIKE', '%'.$request->searchPhrase.'%')
                        ->orWhere('employees.nrp', 'LIKE', '%'.$request->searchPhrase.'%')
                        ->orWhere('departments.name', 'LIKE', '%'.$request->searchPhrase.'%')
                        ->orWhere('positions.name', 'LIKE', '%'.$request->searchPhrase.'%');
                })->orderBy($sort, $dir)->paginate($pageSize);

            return [
                'rowCount' => $absensi->perPage(),
                'total' => $absensi->total(),
                'current' => $absensi->currentPage(),
                'rows' => $absensi->items(),
            ];
        }

        return view('absensi.index', [
            'breadcrumbs' => [
                'hcgs/dashboard' => 'HCGS',
                'absensi' => 'Absensi'
            ]
        ]);
    }

    public function create()
    {
        return view('absensi.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AbsensiRequest $request)
    {
        $this->authorize('create', Absensi::class);
        return Absensi::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Absensi $absensi)
    {
        $this->authorize('view', Absensi::class);
        return $absensi;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AbsensiRequest $request, Absensi $absensi)
    {
        $this->authorize('update', Absensi::class);
        $absensi->update($request->all());
        return $absensi;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Absensi $absensi)
    {
        $this->authorize('delete', Absensi::class);
        return ['success' => $absensi->delete()];
    }

    public function export(Request $request)
    {
        $this->authorize('export', Absensi::class);
        return Excel::download(new AbsensiExport($request), "absensi-{$request->from}-to-{$request->to}.xlsx");
    }
}
