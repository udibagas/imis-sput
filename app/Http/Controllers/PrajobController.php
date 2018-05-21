<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Prajob;
use App\Http\Requests\PrajobRequest;
use App\Exports\PrajobExport;
use Excel;

class PrajobController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view', Prajob::class);

        if ($request->ajax())
        {
            $pageSize = $request->rowCount > 0 ? $request->rowCount : 1000000;
            $request['page'] = $request->current;
            $sort = $request->sort ? key($request->sort) : 'prajobs.tgl';
            $dir = $request->sort ? $request->sort[$sort] : 'DESC';

            $prajob = Prajob::selectRaw('
                    prajobs.*,
                    prajobs.approval_status AS status,
                    employees.name AS name,
                    employees.nrp AS nrp
                ')
                ->join('employees', 'employees.id', '=', 'prajobs.employee_id')
                ->when($request->searchPhrase, function($query) use ($request) {
                    return $query->where('employees.name', 'LIKE', '%'.$request->searchPhrase.'%')
                        ->orWhere('employees.nrp', 'LIKE', '%'.$request->searchPhrase.'%');
                })->orderBy($sort, $dir)->paginate($pageSize);

            return [
                'rowCount' => $prajob->perPage(),
                'total' => $prajob->total(),
                'current' => $prajob->currentPage(),
                'rows' => $prajob->items(),
            ];
        }

        return view('prajob.index', [
            'breadcrumbs' => [
                'hcgs' => 'HCGS',
                'prajob' => 'Prajob'
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PrajobRequest $request)
    {
        $this->authorize('create', Prajob::class);
        return Prajob::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Prajob $prajob)
    {
        $this->authorize('view', Prajob::class);
        return $prajob;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PrajobRequest $request, Prajob $prajob)
    {
        $this->authorize('update', Prajob::class);
        $prajob->update($request->all());
        return $prajob;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Prajob $prajob)
    {
        $this->authorize('delete', Prajob::class);
        return ['success' => $prajob->delete()];
    }

    public function export(Request $request)
    {
        $this->authorize('export', Prajob::class);
        return Excel::download(new PrajobExport($request), "prajobs-{$request->from}-to-{$request->to}.xlsx");
    }
}
