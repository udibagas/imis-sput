<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pitstop;
use App\Http\Requests\PitstopRequest;

class PitstopController extends Controller
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
            $sort = $request->sort ? key($request->sort) : 'pitstops.time_in';
            $dir = $request->sort ? $request->sort[$sort] : 'desc';

            $pitstop = Pitstop::selectRaw('
                    pitstops.*,
                    units.name AS unit,
                    stations.name AS station
                ')
                ->join('units', 'units.id', '=', 'pitstops.unit_id')
                ->join('stations', 'stations.id', '=', 'pitstops.station_id')
                ->when($request->searchPhrase, function($query) use ($request) {
                    return $query->where('stations.name', 'LIKE', '%'.$request->searchPhrase.'%')
                        ->orWhere('units.name', 'LIKE', '%'.$request->searchPhrase.'%')
                        ->orWhere('pitstop.description', 'LIKE', '%'.$request->searchPhrase.'%');
                })->orderBy($sort, $dir)->paginate($pageSize);

            return [
                'rowCount' => $pitstop->perPage(),
                'total' => $pitstop->total(),
                'current' => $pitstop->currentPage(),
                'rows' => $pitstop->items(),
            ];
        }

        return view('pitstop.index', [
            'breadcrumbs' => [
                'plant/dashboard' => 'Plant',
                'pitstop' => 'Pitstop'
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PitstopRequest $request)
    {
        $input = $request->all();
        $input['user_id'] = auth()->user()->id;
        return Pitstop::create($input);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Pitstop $pitstop)
    {
        return $pitstop;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PitstopRequest $request, Pitstop $pitstop)
    {
        $pitstop->update($request->all());
        return $pitstop;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pitstop $pitstop)
    {
        return ['success' => $pitstop->delete()];
    }
}
