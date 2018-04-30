<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Seam;
use App\Http\Requests\SeamRequest;

class SeamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view', Seam::class);

        if ($request->ajax())
        {
            $pageSize = $request->rowCount > 0 ? $request->rowCount : 1000000;
            $request['page'] = $request->current;
            $sort = $request->sort ? key($request->sort) : 'name';
            $dir = $request->sort ? $request->sort[$sort] : 'asc';

            $seam = Seam::when($request->searchPhrase, function($query) use ($request) {
                    return $query->where('name', 'LIKE', '%'.$request->searchPhrase.'%')
                        ->orWhere('description', 'LIKE', '%'.$request->searchPhrase.'%');
                })->orderBy($sort, $dir)->paginate($pageSize);

            return [
                'rowCount' => $seam->perPage(),
                'total' => $seam->total(),
                'current' => $seam->currentPage(),
                'rows' => $seam->items(),
            ];
        }

        return view('seam.index', [
            'breadcrumbs' => [
                'hcgs/dashboard' => 'HCGS',
                '#' => 'Master Data',
                'seam' => 'Seam'
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SeamRequest $request)
    {
        $this->authorize('create', Seam::class);
        return Seam::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Seam $seam)
    {
        $this->authorize('view', Seam::class);
        return $seam;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SeamRequest $request, Seam $seam)
    {
        $this->authorize('update', Seam::class);
        $seam->update($request->all());
        return $seam;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Seam $seam)
    {
        $this->authorize('delete', Seam::class);
        return ['success' => $seam->delete()];
    }
}
