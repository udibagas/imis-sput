<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AssetVendor;
use App\Http\Requests\AssetVendorRequest;

class AssetVendorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view', AssetVendor::class);

        if ($request->ajax())
        {
            $pageSize = $request->rowCount > 0 ? $request->rowCount : 1000000;
            $request['page'] = $request->current;
            $sort = $request->sort ? key($request->sort) : 'name';
            $dir = $request->sort ? $request->sort[$sort] : 'asc';

            $assetVendor = AssetVendor::when($request->searchPhrase, function($query) use ($request) {
                    return $query->where('name', 'LIKE', '%'.$request->searchPhrase.'%')
                        ->orWhere('phone', 'LIKE', '%'.$request->searchPhrase.'%')
                        ->orWhere('address', 'LIKE', '%'.$request->searchPhrase.'%');
                })->orderBy($sort, $dir)->paginate($pageSize);

            return [
                'rowCount' => $assetVendor->perPage(),
                'total' => $assetVendor->total(),
                'current' => $assetVendor->currentPage(),
                'rows' => $assetVendor->items(),
            ];
        }

        return view('assetVendor.index', [
            'breadcrumbs' => [
                'hcgs/dashboard' => 'HCGS',
                '#' => 'Master Data',
                'assetVendor' => 'Asset Vendors'
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AssetVendorRequest $request)
    {
        $this->authorize('create', AssetVendor::class);
        return AssetVendor::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(AssetVendor $assetVendor)
    {
        $this->authorize('view', AssetVendor::class);
        return $assetVendor;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AssetVendorRequest $request, AssetVendor $assetVendor)
    {
        $this->authorize('update', AssetVendor::class);
        $assetVendor->update($request->all());
        return $assetVendor;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(AssetVendor $assetVendor)
    {
        $this->authorize('delete', AssetVendor::class);
        return ['success' => $assetVendor->delete()];
    }
}
