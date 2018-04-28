<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\RunningText;
use App\Http\Requests\RunningTextRequest;

class RunningTextController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view', RunningText::class);

        if ($request->ajax())
        {
            $pageSize = $request->rowCount > 0 ? $request->rowCount : 1000000;
            $request['page'] = $request->current;
            $sort = $request->sort ? key($request->sort) : 'module';
            $dir = $request->sort ? $request->sort[$sort] : 'asc';

            $runningText = RunningText::when($request->searchPhrase, function($query) use ($request) {
                    return $query->where('text', 'LIKE', '%'.$request->searchPhrase.'%')
                        ->orWhere('module', 'LIKE', '%'.$request->searchPhrase.'%');
                })->orderBy($sort, $dir)->paginate($pageSize);

            return [
                'rowCount' => $runningText->perPage(),
                'total' => $runningText->total(),
                'current' => $runningText->currentPage(),
                'rows' => $runningText->items(),
            ];
        }

        return view('runningText.index', [
            'breadcrumbs' => [
                '#' => 'Administration',
                'runningText' => 'Running Text'
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RunningTextRequest $request)
    {
        $this->authorize('create', RunningText::class);
        return RunningText::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(RunningText $runningText)
    {
        $this->authorize('view', RunningText::class);
        return $runningText;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RunningTextRequest $request, RunningText $runningText)
    {
        $this->authorize('update', RunningText::class);
        $runningText->update($request->all());
        return $runningText;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(RunningText $runningText)
    {
        $this->authorize('delete', RunningText::class);
        return ['success' => $runningText->delete()];
    }
}
