<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PlanCategory;
use App\Http\Requests\PlanCategoryRequest;

class PlanCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view', PlanCategory::class);

        if ($request->ajax())
        {
            $pageSize = $request->rowCount > 0 ? $request->rowCount : 1000000;
            $request['page'] = $request->current;
            $sort = $request->sort ? key($request->sort) : 'name';
            $dir = $request->sort ? $request->sort[$sort] : 'asc';

            $planCategory = PlanCategory::when($request->searchPhrase, function($query) use ($request) {
                    return $query->where('name', 'LIKE', '%'.$request->searchPhrase.'%')
                        ->orWhere('description', 'LIKE', '%'.$request->searchPhrase.'%');
                })->orderBy($sort, $dir)->paginate($pageSize);

            return [
                'rowCount' => $planCategory->perPage(),
                'total' => $planCategory->total(),
                'current' => $planCategory->currentPage(),
                'rows' => $planCategory->items(),
            ];
        }

        return view('planCategory.index', [
            'breadcrumbs' => [
                'operation/dashboard' => 'Operation',
                '#' => 'Master Data',
                'planCategory' => 'Plan Categories'
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PlanCategoryRequest $request)
    {
        $this->authorize('create', PlanCategory::class);
        return PlanCategory::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(PlanCategory $planCategory)
    {
        $this->authorize('view', PlanCategory::class);
        return $planCategory;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PlanCategoryRequest $request, PlanCategory $planCategory)
    {
        $this->authorize('update', PlanCategory::class);
        $planCategory->update($request->all());
        return $planCategory;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(PlanCategory $planCategory)
    {
        $this->authorize('delete', PlanCategory::class);
        return ['success' => $planCategory->delete()];
    }
}
