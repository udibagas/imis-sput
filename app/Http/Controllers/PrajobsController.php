<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Prajobs;
use App\Http\Requests\PrajobsRequest;

class PrajobsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax())
        {
            $pageSize = $request->rowCount > 0 ? $request->rowCount : 1000000;
            $request['page'] = $request->current;
            $sort = $request->sort ? key($request->sort) : 'prajobs.name';
            $dir = $request->sort ? $request->sort[$sort] : 'asc';

            $prajob = Prajobs::selectRaw('
                    prajobs.*,
                    departments.name AS department,
                    offices.name AS office,
                    owners.name AS owner,
                    positions.name AS position
                ')
                ->join('departments', 'departments.id', '=', 'prajobs.department_id')
                ->join('offices', 'offices.id', '=', 'prajobs.office_id', 'LEFT')
                ->join('owners', 'owners.id', '=', 'prajobs.owner_id', 'LEFT')
                ->join('positions', 'positions.id', '=', 'prajobs.position_id')
                ->when($request->searchPhrase, function($query) use ($request) {
                    return $query->where('prajobs.name', 'LIKE', '%'.$request->searchPhrase.'%')
                        ->orWhere('prajobs.nrp', 'LIKE', '%'.$request->searchPhrase.'%')
                        ->orWhere('departments.name', 'LIKE', '%'.$request->searchPhrase.'%')
                        ->orWhere('offices.name', 'LIKE', '%'.$request->searchPhrase.'%')
                        ->orWhere('owners.name', 'LIKE', '%'.$request->searchPhrase.'%')
                        ->orWhere('positions.name', 'LIKE', '%'.$request->searchPhrase.'%');
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
                'hcgs/dashboard' => 'HCGS',
                '#' => 'Master Data',
                'praJob' => 'Pre Jobs'
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PrajobsRequest $request)
    {
        return Prajobs::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Prajobs $prajob)
    {
        return $prajob;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PrajobsRequest $request, Prajobs $prajob)
    {
        $prajob->update($request->all());
        return $prajob;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Prajobs $prajob)
    {
        return ['success' => $prajob->delete()];
    }
}
