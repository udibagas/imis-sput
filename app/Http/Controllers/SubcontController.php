<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Subcont;
use App\Http\Requests\SubcontRequest;

class SubcontController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view', Subcont::class);

        if ($request->ajax())
        {
            $pageSize = $request->rowCount > 0 ? $request->rowCount : 1000000;
            $request['page'] = $request->current;
            $sort = $request->sort ? key($request->sort) : 'name';
            $dir = $request->sort ? $request->sort[$sort] : 'asc';

            $subcont = Subcont::when($request->searchPhrase, function($query) use ($request) {
                    return $query->where('name', 'LIKE', '%'.$request->searchPhrase.'%')
                        ->orWhere('description', 'LIKE', '%'.$request->searchPhrase.'%');
                })->orderBy($sort, $dir)->paginate($pageSize);

            return [
                'rowCount' => $subcont->perPage(),
                'total' => $subcont->total(),
                'current' => $subcont->currentPage(),
                'rows' => $subcont->items(),
            ];
        }

        return view('subcont.index', [
            'breadcrumbs' => [
                'operation' => 'Operation',
                '#' => 'Master Data',
                'subcont' => 'Subcont'
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SubcontRequest $request)
    {
        $this->authorize('create', Subcont::class);
        return Subcont::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Subcont $subcont)
    {
        $this->authorize('view', Subcont::class);
        return $subcont;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SubcontRequest $request, Subcont $subcont)
    {
        $this->authorize('update', Subcont::class);
        $subcont->update($request->all());
        return $subcont;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subcont $subcont)
    {
        $this->authorize('delete', Subcont::class);
        return ['success' => $subcont->delete()];
    }
}
