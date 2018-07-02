<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UnitActivity;
use App\Http\Requests\UnitActivityRequest;

class UnitActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view', UnitActivity::class);

        if ($request->ajax())
        {
            $pageSize = $request->rowCount > 0 ? $request->rowCount : 1000000;
            $request['page'] = $request->current;
            $sort = $request->sort ? key($request->sort) : 'name';
            $dir = $request->sort ? $request->sort[$sort] : 'asc';

            $unitActivity = UnitActivity::when($request->searchPhrase, function($query) use ($request) {
                    return $query->where('name', 'LIKE', '%'.$request->searchPhrase.'%')
                        ->orWhere('description', 'LIKE', '%'.$request->searchPhrase.'%');
                })->orderBy($sort, $dir)->paginate($pageSize);

            return [
                'rowCount' => $unitActivity->perPage(),
                'total' => $unitActivity->total(),
                'current' => $unitActivity->currentPage(),
                'rows' => $unitActivity->items(),
            ];
        }

        return view('unitActivity.index', [
            'breadcrumbs' => [
                'plant/dashboard' => 'Plant',
                '#' => 'Master Data',
                'unitActivity' => 'EGI'
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UnitActivityRequest $request)
    {
        $this->authorize('create', UnitActivity::class);
        return UnitActivity::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(UnitActivity $unitActivity)
    {
        $this->authorize('view', UnitActivity::class);
        return $unitActivity;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UnitActivityRequest $request, UnitActivity $unitActivity)
    {
        $this->authorize('update', UnitActivity::class);
        $unitActivity->update($request->all());
        return $unitActivity;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(UnitActivity $unitActivity)
    {
        $this->authorize('delete', UnitActivity::class);
        return ['success' => $unitActivity->delete()];
    }
}
