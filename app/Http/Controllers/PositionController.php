<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Position;
use App\Http\Requests\PositionRequest;

class PositionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $pageSize = $request->rowCount > 0 ? $request->rowCount : 1000000;
        $request['page'] = $request->current;
        $sort = $request->sort ? key($request->sort) : 'name';
        $dir = $request->sort ? $request->sort[$sort] : 'asc';

        $position = Position::when($request->searchPhrase, function($query) use ($request) {
                        return $query->where('name', 'LIKE', '%'.$request->searchPhrase.'%')
                                     ->orWhere('description', 'LIKE', '%'.$request->searchPhrase.'%');
                    })->orderBy($sort, $dir)->paginate($pageSize);


        if ($request->ajax()) {
            return [
                'rowCount' => $position->perPage(),
                'total' => $position->total(),
                'current' => $position->currentPage(),
                'rows' => $position->items(),
            ];
        }

        return view('position.index', [
            'breadcrumbs' => [
                'hcgs/dashboard' => 'HCGS',
                '#' => 'Master Data',
                'position' => 'Positions'
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PositionRequest $request)
    {
        return Position::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Position $position)
    {
        return $position;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PositionRequest $request, Position $position)
    {
        $position->update($request->all());
        return $position;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Position $position)
    {
        return ['success' => $position->delete()];
    }
}
