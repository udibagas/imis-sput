<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AssetStatus;
use App\Http\Requests\AssetStatusRequest;

class AssetStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view', AssetStatus::class);

        if ($request->ajax())
        {
            $pageSize = $request->rowCount > 0 ? $request->rowCount : 1000000;
            $request['page'] = $request->current;
            $sort = $request->sort ? key($request->sort) : 'code';
            $dir = $request->sort ? $request->sort[$sort] : 'asc';

            $assetStatus = AssetStatus::when($request->searchPhrase, function($query) use ($request) {
                    return $query->where('code', 'LIKE', '%'.$request->searchPhrase.'%')
                        ->orWhere('description', 'LIKE', '%'.$request->searchPhrase.'%');
                })->orderBy($sort, $dir)->paginate($pageSize);

            return [
                'rowCount' => $assetStatus->perPage(),
                'total' => $assetStatus->total(),
                'current' => $assetStatus->currentPage(),
                'rows' => $assetStatus->items(),
            ];
        }

        return view('assetStatus.index', [
            'breadcrumbs' => [
                'hcgs' => 'HCGS',
                '#' => 'Master Data',
                'assetStatus' => 'Asset Status'
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AssetStatusRequest $request)
    {
        $this->authorize('create', AssetStatus::class);
        return AssetStatus::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(AssetStatus $assetStatus)
    {
        $this->authorize('view', AssetStatus::class);
        return $assetStatus;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AssetStatusRequest $request, AssetStatus $assetStatus)
    {
        $this->authorize('update', AssetStatus::class);
        $assetStatus->update($request->all());
        return $assetStatus;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(AssetStatus $assetStatus)
    {
        $this->authorize('delete', AssetStatus::class);
        return ['success' => $assetStatus->delete()];
    }
}
