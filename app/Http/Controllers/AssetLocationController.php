<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AssetLocation;
use App\Http\Requests\AssetLocationRequest;

class AssetLocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view', AssetLocation::class);

        if ($request->ajax())
        {
            $pageSize = $request->rowCount > 0 ? $request->rowCount : 1000000;
            $request['page'] = $request->current;
            $sort = $request->sort ? key($request->sort) : 'asset_locations.name';
            $dir = $request->sort ? $request->sort[$sort] : 'asc';

            $assetLocation = AssetLocation::selectRaw('asset_locations.*, employees.name AS pic')
                ->join('employees', 'employees.id', '=', 'asset_locations.employee_id')
                ->when($request->searchPhrase, function($query) use ($request) {
                    return $query->where('asset_locations.name', 'LIKE', '%'.$request->searchPhrase.'%')
                        ->orWhere('employees.name', 'LIKE', '%'.$request->searchPhrase.'%');
                })->orderBy($sort, $dir)->paginate($pageSize);

            return [
                'rowCount' => $assetLocation->perPage(),
                'total' => $assetLocation->total(),
                'current' => $assetLocation->currentPage(),
                'rows' => $assetLocation->items(),
            ];
        }

        return view('assetLocation.index', [
            'breadcrumbs' => [
                'hcgs' => 'HCGS',
                '#' => 'Master Data',
                'assetLocation' => 'Asset Location'
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AssetLocationRequest $request)
    {
        $this->authorize('create', AssetLocation::class);
        return AssetLocation::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(AssetLocation $assetLocation)
    {
        $this->authorize('view', AssetLocation::class);
        return $assetLocation;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AssetLocationRequest $request, AssetLocation $assetLocation)
    {
        $this->authorize('update', AssetLocation::class);
        $assetLocation->update($request->all());
        return $assetLocation;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(AssetLocation $assetLocation)
    {
        $this->authorize('delete', AssetLocation::class);
        return ['success' => $assetLocation->delete()];
    }
}
