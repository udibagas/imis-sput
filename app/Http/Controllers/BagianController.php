<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Bagian;
use App\Http\Requests\BagianRequest;

class BagianController extends Controller
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

        $bagian = Bagian::when($request->searchPhrase, function($query) use ($request) {
                        return $query->where('name', 'LIKE', '%'.$request->searchPhrase.'%')
                                     ->orWhere('description', 'LIKE', '%'.$request->searchPhrase.'%');
                    })->orderBy($sort, $dir)->paginate($pageSize);


        if ($request->ajax()) {
            return [
                'rowCount' => $bagian->perPage(),
                'total' => $bagian->total(),
                'current' => $bagian->currentPage(),
                'rows' => $bagian->items(),
            ];
        }

        return view('bagian.index', [
            'breadcrumbs' => [
                'plant/dashboard' => 'Plant',
                '#' => 'Master Data',
                'bagian' => 'Bagian'
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BagianRequest $request)
    {
        return Bagian::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Bagian $bagian)
    {
        return $bagian;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BagianRequest $request, Bagian $bagian)
    {
        $bagian->update($request->all());
        return $bagian;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bagian $bagian)
    {
        return ['success' => $bagian->delete()];
    }
}
