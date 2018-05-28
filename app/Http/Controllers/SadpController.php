<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Sadp;
use App\Http\Requests\SadpRequest;

class SadpController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view', Sadp::class);

        if ($request->ajax())
        {
            $pageSize = $request->rowCount > 0 ? $request->rowCount : 1000000;
            $request['page'] = $request->current;
            $sort = $request->sort ? key($request->sort) : 'name';
            $dir = $request->sort ? $request->sort[$sort] : 'asc';

            $sadp = Sadp::when($request->searchPhrase, function($query) use ($request) {
                    return $query->where('name', 'LIKE', '%'.$request->searchPhrase.'%')
                        ->orWhere('description', 'LIKE', '%'.$request->searchPhrase.'%');
                })->orderBy($sort, $dir)->paginate($pageSize);

            return [
                'rowCount' => $sadp->perPage(),
                'total' => $sadp->total(),
                'current' => $sadp->currentPage(),
                'rows' => $sadp->items(),
            ];
        }

        return view('sadp.index', [
            'breadcrumbs' => [
                'plant/dashboard' => 'Plant',
                '#' => 'Master Data',
                'sadp' => 'Sadp'
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SadpRequest $request)
    {
        $this->authorize('create', Sadp::class);
        return Sadp::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Sadp $sadp)
    {
        $this->authorize('view', Sadp::class);
        return $sadp;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SadpRequest $request, Sadp $sadp)
    {
        $this->authorize('update', Sadp::class);
        $sadp->update($request->all());
        return $sadp;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sadp $sadp)
    {
        $this->authorize('delete', Sadp::class);
        return ['success' => $sadp->delete()];
    }
}
