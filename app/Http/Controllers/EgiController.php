<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Egi;
use App\Http\Requests\EgiRequest;

class EgiController extends Controller
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

        $egi = Egi::when($request->searchPhrase, function($query) use ($request) {
                        return $query->where('name', 'LIKE', '%'.$request->searchPhrase.'%')
                                     ->orWhere('description', 'LIKE', '%'.$request->searchPhrase.'%');
                    })->orderBy($sort, $dir)->paginate($pageSize);


        if ($request->ajax()) {
            return [
                'rowCount' => $egi->perPage(),
                'total' => $egi->total(),
                'current' => $egi->currentPage(),
                'rows' => $egi->items(),
            ];
        }

        return view('egi.index', [
            'breadcrumbs' => [
                '#' => 'EGI'
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EgiRequest $request)
    {
        return Egi::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Egi $egi)
    {
        return $egi;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EgiRequest $request, Egi $egi)
    {
        $egi->update($request->all());
        return $egi;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Egi $egi)
    {
        return ['success' => $egi->delete()];
    }
}
