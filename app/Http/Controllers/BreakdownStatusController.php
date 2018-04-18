<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\BreakdownStatus;
use App\Http\Requests\BreakdownStatusRequest;

class BreakdownStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $pageSize = $request->rowCount > 0 ? $request->rowCount : 1000000;
        $request['page'] = $request->current;
        $sort = $request->sort ? key($request->sort) : 'code';
        $dir = $request->sort ? $request->sort[$sort] : 'asc';

        $breakdownStatus = BreakdownStatus::when($request->searchPhrase, function($query) use ($request) {
                        return $query->where('code', 'LIKE', '%'.$request->searchPhrase.'%')
                                     ->orWhere('description', 'LIKE', '%'.$request->searchPhrase.'%');
                    })->orderBy($sort, $dir)->paginate($pageSize);


        if ($request->ajax()) {
            return [
                'rowCount' => $breakdownStatus->perPage(),
                'total' => $breakdownStatus->total(),
                'current' => $breakdownStatus->currentPage(),
                'rows' => $breakdownStatus->items(),
            ];
        }

        return view('breakdownStatus.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BreakdownStatusRequest $request)
    {
        return BreakdownStatus::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(BreakdownStatus $breakdownStatus)
    {
        return $breakdownStatus;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BreakdownStatusRequest $request, BreakdownStatus $breakdownStatus)
    {
        $breakdownStatus->update($request->all());
        return $breakdownStatus;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(BreakdownStatus $breakdownStatus)
    {
        return ['success' => $breakdownStatus->delete()];
    }
}
