<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\LostTimeCategory;
use App\Http\Requests\LostTimeCategoryRequest;

class LostTimeCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view', LostTimeCategory::class);

        if ($request->ajax())
        {
            $pageSize = $request->rowCount > 0 ? $request->rowCount : 1000000;
            $request['page'] = $request->current;
            $sort = $request->sort ? key($request->sort) : 'code';
            $dir = $request->sort ? $request->sort[$sort] : 'asc';

            $lostTimeCategory = LostTimeCategory::when($request->searchPhrase, function($query) use ($request) {
                    return $query->where('code', 'LIKE', '%'.$request->searchPhrase.'%')
                        ->orWhere('description', 'LIKE', '%'.$request->searchPhrase.'%');
                })->orderBy($sort, $dir)->paginate($pageSize);

            return [
                'rowCount' => $lostTimeCategory->perPage(),
                'total' => $lostTimeCategory->total(),
                'current' => $lostTimeCategory->currentPage(),
                'rows' => $lostTimeCategory->items(),
            ];
        }

        return view('lostTimeCategory.index', [
            'breadcrumbs' => [
                'operation/dashboard' => 'Operation',
                '#' => 'Master Data',
                'lostTimeCategory' => 'Lost Time Categories'
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LostTimeCategoryRequest $request)
    {
        $this->authorize('create', LostTimeCategory::class);
        return LostTimeCategory::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(LostTimeCategory $lostTimeCategory)
    {
        $this->authorize('view', LostTimeCategory::class);
        return $lostTimeCategory;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(LostTimeCategoryRequest $request, LostTimeCategory $lostTimeCategory)
    {
        $this->authorize('update', LostTimeCategory::class);
        $lostTimeCategory->update($request->all());
        return $lostTimeCategory;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(LostTimeCategory $lostTimeCategory)
    {
        $this->authorize('delete', LostTimeCategory::class);
        return ['success' => $lostTimeCategory->delete()];
    }
}
