<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Barge;
use App\Http\Requests\BargeRequest;

class BargeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view', Barge::class);

        if ($request->ajax())
        {
            $pageSize = $request->rowCount > 0 ? $request->rowCount : 1000000;
            $request['page'] = $request->current;
            $sort = $request->sort ? key($request->sort) : 'barges.name';
            $dir = $request->sort ? $request->sort[$sort] : 'asc';

            $barge = Barge::selectRaw('barges.*, jetties.name AS jetty')
                ->join('jetties', 'jetties.id', '=', 'barges.jetty_id', 'LEFT')
                ->when($request->searchPhrase, function($query) use ($request) {
                    return $query->where('barges.name', 'LIKE', '%'.$request->searchPhrase.'%')
                        ->orWhere('jetties.name', 'LIKE', '%'.$request->searchPhrase.'%')
                        ->orWhere('barges.description', 'LIKE', '%'.$request->searchPhrase.'%');
                })->orderBy($sort, $dir)->paginate($pageSize);

            return [
                'rowCount' => $barge->perPage(),
                'total' => $barge->total(),
                'current' => $barge->currentPage(),
                'rows' => $barge->items(),
            ];
        }

        return view('barge.index', [
            'breadcrumbs' => [
                'operation' => 'Operation',
                '#' => 'Master Data',
                'barge' => 'Barge'
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BargeRequest $request)
    {
        $this->authorize('create', Barge::class);
        return Barge::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Barge $barge)
    {
        $this->authorize('view', Barge::class);
        return $barge;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BargeRequest $request, Barge $barge)
    {
        $this->authorize('update', Barge::class);
        $barge->update($request->all());
        return $barge;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Barge $barge)
    {
        $this->authorize('delete', Barge::class);
        return ['success' => $barge->delete()];
    }

    public function getAnchored()
    {
        return Barge::orderBy('updated_at', 'DESC')
            ->where('anchored', 1)->get();
    }

    public function resume(Request $request)
    {
        if ($request->ajax())
        {
            $labelSetting = [
                'show' => true,
                'position' => 'top',
                'fontSize' => 16,
            ];

            return [
                [
                    'name' => 'PLAN',
                    'type' => 'bar',
                    'barGap' => 0,
                    // 'color' => 'navy',
                    'label' => $labelSetting,
                    'data' => [rand(150000, 32000), rand(150000, 32000), rand(150000, 32000), rand(150000, 32000)]
                ],
                [
                    'name' => 'ACTUAL',
                    'type' => 'bar',
                    'barGap' => 0,
                    // 'color' => 'green',
                    'label' => $labelSetting,
                    'data' => [rand(150000, 32000), rand(150000, 32000), rand(150000, 32000), rand(150000, 32000)]
                ]
            ];
        }

        return view('barge.resume', [
            'breadcrumbs' => [
                'operation/dashboard' => 'Operation',
                '#' => 'Status Jetty',
                'barge/resume' => 'Resume Barging Daily'
            ]
        ]);
    }
}
