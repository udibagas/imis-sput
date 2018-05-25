<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Dormitory;
use App\Http\Requests\DormitoryRequest;

class DormitoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view', Dormitory::class);

        if ($request->ajax())
        {
            $pageSize = $request->rowCount > 0 ? $request->rowCount : 1000000;
            $request['page'] = $request->current;
            $sort = $request->sort ? key($request->sort) : 'name';
            $dir = $request->sort ? $request->sort[$sort] : 'asc';

            $dormitory = Dormitory::when($request->searchPhrase, function($query) use ($request) {
                    return $query->where('name', 'LIKE', '%'.$request->searchPhrase.'%')
                        ->orWhere('description', 'LIKE', '%'.$request->searchPhrase.'%');
                })->orderBy($sort, $dir)->paginate($pageSize);

            return [
                'rowCount' => $dormitory->perPage(),
                'total' => $dormitory->total(),
                'current' => $dormitory->currentPage(),
                'rows' => $dormitory->items(),
            ];
        }

        return view('dormitory.index', [
            'breadcrumbs' => [
                'hcgs/dashboard' => 'HCGS',
                '#' => 'Master Data',
                'dormitory' => 'Dormitory'
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DormitoryRequest $request)
    {
        $this->authorize('create', Dormitory::class);
        return Dormitory::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Dormitory $dormitory)
    {
        $this->authorize('view', Dormitory::class);
        return $dormitory;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(DormitoryRequest $request, Dormitory $dormitory)
    {
        $this->authorize('update', Dormitory::class);
        $dormitory->update($request->all());
        return $dormitory;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Dormitory $dormitory)
    {
        $this->authorize('delete', Dormitory::class);
        return ['success' => $dormitory->delete()];
    }
}
