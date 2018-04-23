<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\BreakdownCategory;
use App\Http\Requests\BreakdownCategoryRequest;

class BreakdownCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view', BreakdownCategory::class);

        if ($request->ajax())
        {
            $pageSize = $request->rowCount > 0 ? $request->rowCount : 1000000;
            $request['page'] = $request->current;
            $sort = $request->sort ? key($request->sort) : 'name';
            $dir = $request->sort ? $request->sort[$sort] : 'asc';

            $breakdownCategory = BreakdownCategory::when($request->searchPhrase, function($query) use ($request) {
                    return $query->where('name', 'LIKE', '%'.$request->searchPhrase.'%')
                        ->orWhere('description_id', 'LIKE', '%'.$request->searchPhrase.'%')
                        ->orWhere('description_en', 'LIKE', '%'.$request->searchPhrase.'%');
                })->orderBy($sort, $dir)->paginate($pageSize);

            return [
                'rowCount' => $breakdownCategory->perPage(),
                'total' => $breakdownCategory->total(),
                'current' => $breakdownCategory->currentPage(),
                'rows' => $breakdownCategory->items(),
            ];
        }

        return view('breakdownCategory.index', [
            'breadcrumbs' => [
                'plant/dashboard' => 'Plant',
                '#' => 'Master Data',
                'breakdownCategory' => 'Breakdown Categories'
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BreakdownCategoryRequest $request)
    {
        $this->authorize('create', BreakdownCategory::class);
        return BreakdownCategory::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(BreakdownCategory $breakdownCategory)
    {
        $this->authorize('view', BreakdownCategory::class);
        return $breakdownCategory;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BreakdownCategoryRequest $request, BreakdownCategory $breakdownCategory)
    {
        $this->authorize('update', BreakdownCategory::class);
        $breakdownCategory->update($request->all());
        return $breakdownCategory;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(BreakdownCategory $breakdownCategory)
    {
        $this->authorize('delete', BreakdownCategory::class);
        return ['success' => $breakdownCategory->delete()];
    }
}
