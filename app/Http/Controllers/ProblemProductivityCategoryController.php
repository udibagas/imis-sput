<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ProblemProductivityCategory;
use App\Http\Requests\ProblemProductivityCategoryRequest;

class ProblemProductivityCategoryController extends Controller
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

        $problemProductivityCategory = ProblemProductivityCategory::when($request->searchPhrase, function($query) use ($request) {
                        return $query->where('code', 'LIKE', '%'.$request->searchPhrase.'%')
                                     ->orWhere('description', 'LIKE', '%'.$request->searchPhrase.'%');
                    })->orderBy($sort, $dir)->paginate($pageSize);


        if ($request->ajax()) {
            return [
                'rowCount' => $problemProductivityCategory->perPage(),
                'total' => $problemProductivityCategory->total(),
                'current' => $problemProductivityCategory->currentPage(),
                'rows' => $problemProductivityCategory->items(),
            ];
        }

        return view('problemProductivityCategory.index', [
            'breadcrumbs' => [
                '#' => 'Problem Productivity Categories'
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProblemProductivityCategoryRequest $request)
    {
        return ProblemProductivityCategory::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(ProblemProductivityCategory $problemProductivityCategory)
    {
        return $problemProductivityCategory;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProblemProductivityCategoryRequest $request, ProblemProductivityCategory $problemProductivityCategory)
    {
        $problemProductivityCategory->update($request->all());
        return $problemProductivityCategory;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProblemProductivityCategory $problemProductivityCategory)
    {
        return ['success' => $problemProductivityCategory->delete()];
    }
}
