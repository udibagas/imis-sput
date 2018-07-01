<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tugboat;
use App\Http\Requests\TugboatRequest;

class TugboatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view', Tugboat::class);

        if ($request->ajax())
        {
            $pageSize = $request->rowCount > 0 ? $request->rowCount : 1000000;
            $request['page'] = $request->current;
            $sort = $request->sort ? key($request->sort) : 'tugboats.name';
            $dir = $request->sort ? $request->sort[$sort] : 'asc';

            $tugboat = Tugboat::selectRaw('tugboats.*, jetties.name AS jetty')
                ->join('jetties', 'jetties.id', '=', 'tugboats.jetty_id', 'LEFT')
                ->when($request->searchPhrase, function($query) use ($request) {
                    return $query->where('tugboats.name', 'LIKE', '%'.$request->searchPhrase.'%')
                        ->orWhere('tugboats.description', 'LIKE', '%'.$request->searchPhrase.'%');
                })->orderBy($sort, $dir)->paginate($pageSize);

            return [
                'rowCount' => $tugboat->perPage(),
                'total' => $tugboat->total(),
                'current' => $tugboat->currentPage(),
                'rows' => $tugboat->items(),
            ];
        }

        return view('tugboat.index', [
            'breadcrumbs' => [
                'operation' => 'Operation',
                '#' => 'Master Data',
                'tugboat' => 'Tugboat'
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TugboatRequest $request)
    {
        $this->authorize('create', Tugboat::class);
        return Tugboat::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Tugboat $tugboat)
    {
        $this->authorize('view', Tugboat::class);
        return $tugboat;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TugboatRequest $request, Tugboat $tugboat)
    {
        $this->authorize('update', Tugboat::class);
        $tugboat->update($request->all());
        return $tugboat;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tugboat $tugboat)
    {
        $this->authorize('delete', Tugboat::class);
        return ['success' => $tugboat->delete()];
    }
}
