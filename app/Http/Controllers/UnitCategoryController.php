<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UnitCategory;
use App\Http\Requests\UnitCategoryRequest;

class UnitCategoryController extends Controller
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

            $unitCategory = UnitCategory::when($request->searchPhrase, function($query) use ($request) {
                    return $query->where('name', 'LIKE', '%'.$request->searchPhrase.'%')
                        ->orWhere('description', 'LIKE', '%'.$request->searchPhrase.'%');
                })->orderBy($sort, $dir)->paginate($pageSize);

            return [
                'rowCount' => $unitCategory->perPage(),
                'total' => $unitCategory->total(),
                'current' => $unitCategory->currentPage(),
                'rows' => $unitCategory->items(),
            ];
        }

        return view('unitCategory.index', [
            'breadcrumbs' => [
                'plant/dashboard' => 'Plant',
                '#' => 'Master Data',
                'unitCategory' => 'Unit Categories'
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UnitCategoryRequest $request)
    {
        return UnitCategory::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(UnitCategory $unitCategory)
    {
        return $unitCategory;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UnitCategoryRequest $request, UnitCategory $unitCategory)
    {
        $unitCategory->update($request->all());
        return $unitCategory;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(UnitCategory $unitCategory)
    {
        return ['success' => $unitCategory->delete()];
    }
}
