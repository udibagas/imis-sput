<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DraughtSurvey;
use App\Http\Requests\DraughtSurveyRequest;

class DraughtSurveyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view', DraughtSurvey::class);

        if ($request->ajax())
        {
            $pageSize = $request->rowCount > 0 ? $request->rowCount : 1000000;
            $request['page'] = $request->current;
            $sort = $request->sort ? key($request->sort) : 'draught_surveys.id';
            $dir = $request->sort ? $request->sort[$sort] : 'DESC';

            $draughtSurvey = DraughtSurvey::when($request->searchPhrase, function($query) use ($request) {
                    return $query->where('name', 'LIKE', '%'.$request->searchPhrase.'%')
                        ->orWhere('description', 'LIKE', '%'.$request->searchPhrase.'%');
                })->orderBy($sort, $dir)->paginate($pageSize);

            return [
                'rowCount' => $draughtSurvey->perPage(),
                'total' => $draughtSurvey->total(),
                'current' => $draughtSurvey->currentPage(),
                'rows' => $draughtSurvey->items(),
            ];
        }

        return view('draughtSurvey.index', [
            'breadcrumbs' => [
                'operation' => 'Operation',
                'draughtSurvey' => 'Draught Survey'
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DraughtSurveyRequest $request)
    {
        $this->authorize('create', DraughtSurvey::class);
        return DraughtSurvey::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(DraughtSurvey $draughtSurvey)
    {
        $this->authorize('view', DraughtSurvey::class);
        return $draughtSurvey;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(DraughtSurveyRequest $request, DraughtSurvey $draughtSurvey)
    {
        $this->authorize('update', DraughtSurvey::class);
        $draughtSurvey->update($request->all());
        return $draughtSurvey;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(DraughtSurvey $draughtSurvey)
    {
        $this->authorize('delete', DraughtSurvey::class);
        return ['success' => $draughtSurvey->delete()];
    }
}
