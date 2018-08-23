<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Area;
use App\StockArea;
use App\Http\Requests\AreaRequest;

class AreaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view', Area::class);

        if ($request->ajax())
        {
            $pageSize = $request->rowCount > 0 ? $request->rowCount : 1000000;
            $request['page'] = $request->current;
            $sort = $request->sort ? key($request->sort) : 'name';
            $dir = $request->sort ? $request->sort[$sort] : 'asc';

            $area = Area::selectRaw('areas.*, jetties.name AS jetty')
                ->join('jetties', 'jetties.id', '=', 'areas.jetty_id', 'LEFT')
                ->when($request->searchPhrase, function($query) use ($request) {
                    return $query->where('name', 'LIKE', '%'.$request->searchPhrase.'%')
                        ->orWhere('description', 'LIKE', '%'.$request->searchPhrase.'%');
                })->orderBy($sort, $dir)->paginate($pageSize);

            return [
                'rowCount' => $area->perPage(),
                'total' => $area->total(),
                'current' => $area->currentPage(),
                'rows' => $area->items(),
            ];
        }

        return view('area.index', [
            'breadcrumbs' => [
                '0' => 'Operation',
                '#' => 'Master Data',
                'area' => 'Area'
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AreaRequest $request)
    {
        $this->authorize('create', Area::class);
        $area = Area::create($request->all());
        $area->stockArea()->createMany($request->stock_area);
        return $area;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Area $area)
    {
        $this->authorize('view', Area::class);
        return $area;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AreaRequest $request, Area $area)
    {
        $this->authorize('update', Area::class);
        $area->update($request->all());

        foreach ($request->stock_area as $r)
        {
            if (isset($r['id'])) {
                StockArea::find($r['id'])->update($r);
            }

            else {
                $area->stockArea()->create($r);
            }
        }

        return $area;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Area $area)
    {
        $this->authorize('delete', Area::class);
        $area->stockArea()->delete();
        return ['success' => $area->delete()];
    }
}
