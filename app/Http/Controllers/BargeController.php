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
        if ($request->ajax())
        {
            $pageSize = $request->rowCount > 0 ? $request->rowCount : 1000000;
            $request['page'] = $request->current;
            $sort = $request->sort ? key($request->sort) : 'name';
            $dir = $request->sort ? $request->sort[$sort] : 'asc';

            $barge = Barge::when($request->searchPhrase, function($query) use ($request) {
                    return $query->where('name', 'LIKE', '%'.$request->searchPhrase.'%')
                        ->orWhere('description', 'LIKE', '%'.$request->searchPhrase.'%');
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
                'plant/dashboard' => 'Plant',
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
        return ['success' => $barge->delete()];
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
                    'color' => 'navy',
                    'label' => $labelSetting,
                    'data' => [rand(150000, 32000), rand(150000, 32000), rand(150000, 32000), rand(150000, 32000)]
                ],
                [
                    'name' => 'ACTUAL',
                    'type' => 'bar',
                    'barGap' => 0,
                    'color' => 'green',
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
