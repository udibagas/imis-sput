<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AssetCategory;
use App\Http\Requests\AssetCategoryRequest;

class AssetCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view', AssetCategory::class);

        if ($request->ajax())
        {
            $pageSize = $request->rowCount > 0 ? $request->rowCount : 1000000;
            $request['page'] = $request->current;
            $sort = $request->sort ? key($request->sort) : 'name';
            $dir = $request->sort ? $request->sort[$sort] : 'asc';

            $assetCategory = AssetCategory::when($request->searchPhrase, function($query) use ($request) {
                    return $query->where('code', 'LIKE', '%'.$request->searchPhrase.'%')
                        ->orWhere('name', 'LIKE', '%'.$request->searchPhrase.'%')
                        ->orWhere('description', 'LIKE', '%'.$request->searchPhrase.'%');
                })->orderBy($sort, $dir)->paginate($pageSize);

            return [
                'rowCount' => $assetCategory->perPage(),
                'total' => $assetCategory->total(),
                'current' => $assetCategory->currentPage(),
                'rows' => $assetCategory->items(),
            ];
        }

        return view('assetCategory.index', [
            'breadcrumbs' => [
                'hcgs/dashboard' => 'HCGS',
                '#' => 'Master Data',
                'assetCategory' => 'Asset Categories'
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AssetCategoryRequest $request)
    {
        $this->authorize('create', AssetCategory::class);
        return AssetCategory::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(AssetCategory $assetCategory)
    {
        $this->authorize('view', AssetCategory::class);
        return $assetCategory;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AssetCategoryRequest $request, AssetCategory $assetCategory)
    {
        $this->authorize('update', AssetCategory::class);
        $assetCategory->update($request->all());
        return $assetCategory;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(AssetCategory $assetCategory)
    {
        $this->authorize('delete', AssetCategory::class);
        return ['success' => $assetCategory->delete()];
    }
}
