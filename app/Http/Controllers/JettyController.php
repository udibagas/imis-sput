<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jetty;
use App\StockArea;
use App\Http\Requests\JettyRequest;

class JettyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view', Jetty::class);

        if ($request->ajax())
        {
            $pageSize = $request->rowCount > 0 ? $request->rowCount : 1000000;
            $request['page'] = $request->current;
            $sort = $request->sort ? key($request->sort) : 'name';
            $dir = $request->sort ? $request->sort[$sort] : 'asc';

            $jetty = Jetty::when($request->searchPhrase, function($query) use ($request) {
                    return $query->where('name', 'LIKE', '%'.$request->searchPhrase.'%')
                        ->orWhere('description', 'LIKE', '%'.$request->searchPhrase.'%');
                })->orderBy($sort, $dir)->paginate($pageSize);

            return [
                'rowCount' => $jetty->perPage(),
                'total' => $jetty->total(),
                'current' => $jetty->currentPage(),
                'rows' => $jetty->items(),
            ];
        }

        return view('jetty.index', [
            'breadcrumbs' => [
                'plant/dashboard' => 'Plant',
                '#' => 'Master Data',
                'jetty' => 'Jetty'
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(JettyRequest $request)
    {
        $this->authorize('create', Jetty::class);
        $jetty = Jetty::create($request->all());

        foreach ($request->stock_area as $r) {
            $jetty->stockArea()->create($r);
        }

        return $jetty;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Jetty $jetty)
    {
        $this->authorize('view', Jetty::class);
        return $jetty;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(JettyRequest $request, Jetty $jetty)
    {
        $this->authorize('update', Jetty::class);
        $jetty->update($request->all());

        foreach ($request->stock_area as $r)
        {
            if (isset($r['id'])) {
                StockArea::find($r['id'])->update($r);
            }

            else {
                $jetty->stockArea()->create($r);
            }
        }

        return $jetty;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Jetty $jetty)
    {
        $this->authorize('delete', Jetty::class);
        return ['success' => $jetty->delete()];
    }

    public function productivity(Request $request)
    {
        if ($request->ajax())
        {
            // $jetties = Jetty::orderBy('name', 'ASC')->get();
            $series = [];

            $data = [];
            for ($i = 0; $i < 24; $i++) {
                $data[] = rand(3000,5000);
            }

            $series[] = [
                // 'name' => 'JETTY '.$j->name,
                'data' => $data,
                'type' => 'line',
                'label' => [
                    'show' => true,
                    'position' => 'top'
                ]
            ];

            return $series;
        }

        else {
            return view('jetty.productivity', [
                'jetties' => Jetty::orderBy('order', 'ASC')->get(),
                'breadcrumbs' => [
                    'operation/dashboard' => 'Operation',
                    '#' => 'Status Jetty',
                    'jetty/productivity' => 'Productivity'
                ]
            ]);
        }

    }

    public function dwellingTime(Request $request)
    {
        return view('jetty.dwellingTime', [
            'breadcrumbs' => [
                'operation/dashboard' => 'Operation',
                '#' => 'Status Jetty',
                'jetty/dwellingTime' => 'Dwelling Time'
            ]
        ]);
    }
}
