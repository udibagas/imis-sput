<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Asset;
use App\Http\Requests\AssetRequest;
use App\Exports\AssetExport;
use Excel;

class AssetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view', Asset::class);

        if ($request->ajax())
        {
            $pageSize = $request->rowCount > 0 ? $request->rowCount : 1000000;
            $request['page'] = $request->current;
            $sort = $request->sort ? key($request->sort) : 'assets.name';
            $dir = $request->sort ? $request->sort[$sort] : 'asc';

            $asset = Asset::selectRaw('assets.*, asset_locations.name AS location, asset_statuses.code AS status')
                ->join('asset_locations', 'asset_locations.id', '=', 'assets.asset_location_id')
                ->join('asset_statuses', 'asset_statuses.id', '=', 'assets.asset_status_id')
                ->when($request->searchPhrase, function($query) use ($request) {
                    return $query->where('assets.name', 'LIKE', '%'.$request->searchPhrase.'%')
                        ->orWhere('assets.reg_no', 'LIKE', '%'.$request->searchPhrase.'%')
                        ->orWhere('assets.trademark', 'LIKE', '%'.$request->searchPhrase.'%')
                        ->orWhere('assets.version', 'LIKE', '%'.$request->searchPhrase.'%')
                        ->orWhere('assets.sn', 'LIKE', '%'.$request->searchPhrase.'%')
                        ->orWhere('assets.lifetime', 'LIKE', '%'.$request->searchPhrase.'%')
                        ->orWhere('assets.price', 'LIKE', '%'.$request->searchPhrase.'%')
                        ->orWhere('assets.year', 'LIKE', '%'.$request->searchPhrase.'%')
                        ->orWhere('asset_statuses.code', 'LIKE', '%'.$request->searchPhrase.'%')
                        ->orWhere('asset_locations.name', 'LIKE', '%'.$request->searchPhrase.'%');
                })->orderBy($sort, $dir)->paginate($pageSize);

            return [
                'rowCount' => $asset->perPage(),
                'total' => $asset->total(),
                'current' => $asset->currentPage(),
                'rows' => $asset->items(),
            ];
        }

        return view('asset.index', [
            'breadcrumbs' => [
                'hcgs' => 'HCGS',
                'asset' => 'Asset Management'
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AssetRequest $request)
    {
        $this->authorize('create', Asset::class);
        return Asset::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Asset $asset)
    {
        $this->authorize('view', Asset::class);
        return $asset;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AssetRequest $request, Asset $asset)
    {
        $this->authorize('update', Asset::class);
        $asset->update($request->all());
        return $asset;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Asset $asset)
    {
        $this->authorize('delete', Asset::class);
        return ['success' => $asset->delete()];
    }

    public function export(Request $request)
    {
        $this->authorize('export', Asset::class);
        return Excel::download(new AssetExport($request), 'assets.xlsx');
    }

    public function generateQrCode(Asset $asset = null)
    {
        $this->authorize('export', Asset::class);

        $assets = $asset
            ? [$asset]
            : Asset::orderBy('reg_no', 'ASC')->get();

        return view('asset.qrcode', ['assets' => $assets]);
    }
}
