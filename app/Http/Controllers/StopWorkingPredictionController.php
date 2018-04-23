<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\StopWorkingPrediction;
use App\Http\Requests\StopWorkingPredictionRequest;

class StopWorkingPredictionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view', StopWorkingPrediction::class);

        if ($request->ajax())
        {
            $pageSize = $request->rowCount > 0 ? $request->rowCount : 1000000;
            $request['page'] = $request->current;
            $sort = $request->sort ? key($request->sort) : 'jam';
            $dir = $request->sort ? $request->sort[$sort] : 'asc';

            $stopWorkingPrediction = StopWorkingPrediction::when($request->searchPhrase, function($query) use ($request) {
                    return $query->where('jam', 'LIKE', '%'.$request->searchPhrase.'%')
                        ->orWhere('description', 'LIKE', '%'.$request->searchPhrase.'%');
                })->orderBy($sort, $dir)->paginate($pageSize);

            return [
                'rowCount' => $stopWorkingPrediction->perPage(),
                'total' => $stopWorkingPrediction->total(),
                'current' => $stopWorkingPrediction->currentPage(),
                'rows' => $stopWorkingPrediction->items(),
            ];
        }

        return view('stopWorkingPrediction.index', [
            'breadcrumbs' => [
                'hcgs/dashboard' => 'HCGS',
                '#' => 'Master Data',
                'stopWorkingPrediction' => 'Stop Working Prediction'
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StopWorkingPredictionRequest $request)
    {
        $this->authorize('create', StopWorkingPrediction::class);
        return StopWorkingPrediction::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(StopWorkingPrediction $stopWorkingPrediction)
    {
        $this->authorize('view', StopWorkingPrediction::class);
        return $stopWorkingPrediction;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StopWorkingPredictionRequest $request, StopWorkingPrediction $stopWorkingPrediction)
    {
        $this->authorize('update', StopWorkingPrediction::class);
        $stopWorkingPrediction->update($request->all());
        return $stopWorkingPrediction;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(StopWorkingPrediction $stopWorkingPrediction)
    {
        $this->authorize('delete', StopWorkingPrediction::class);
        return ['success' => $stopWorkingPrediction->delete()];
    }
}
