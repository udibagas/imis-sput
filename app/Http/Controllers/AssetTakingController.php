<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AssetTaking;
use App\Http\Requests\AssetTakingRequest;
// use App\Exports\AssetTakingExport;
// use Excel;

class AssetTakingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view', AssetTaking::class);

        if ($request->ajax())
        {
            $pageSize = $request->rowCount > 0 ? $request->rowCount : 1000000;
            $request['page'] = $request->current;
            $sort = $request->sort ? key($request->sort) : 'assets.name';
            $dir = $request->sort ? $request->sort[$sort] : 'asc';

            $assetTaking = AssetTaking::selectRaw('
                    asset_takings.*,
                    assets.*,
                    asset_locations.name AS location,
                    asset_statuses.code AS status,
                    users.name AS user
                ')
                ->join('assets', 'assets.id', '=', 'asset_takings.asset_id')
                ->join('asset_locations', 'asset_locations.id', '=', 'assets.asset_location_id')
                ->join('asset_statuses', 'asset_statuses.id', '=', 'assets.asset_status_id')
                ->join('users', 'users.id', '=', 'asset_takings.user_id')
                ->when($request->searchPhrase, function($query) use ($request) {
                    return $query->where('assets.name', 'LIKE', '%'.$request->searchPhrase.'%')
                        ->orWhere('asset_takings.note', 'LIKE', '%'.$request->searchPhrase.'%')
                        ->orWhere('asset_takings.date', $request->searchPhrase)
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
                'rowCount' => $assetTaking->perPage(),
                'total' => $assetTaking->total(),
                'current' => $assetTaking->currentPage(),
                'rows' => $assetTaking->items(),
            ];
        }

        return view('assetTaking.index', [
            'breadcrumbs' => [
                'hcgs' => 'HCGS',
                'assetTaking' => 'Asset Taking'
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AssetTakingRequest $request)
    {
        $this->authorize('create', AssetTaking::class);
        $input = $request->all();
        $input['user_id'] = auth()->user()->id;
        $assetTaking = AssetTaking::create($input);

        $assetTaking->asset()->update([
            'asset_location_id' => $request->asset_location_id,
            'asset_status_id' => $request->asset_status_id,
        ]);

        return $assetTaking;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(AssetTaking $assetTaking)
    {
        $this->authorize('view', AssetTaking::class);
        return $assetTaking;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AssetTakingRequest $request, AssetTaking $assetTaking)
    {
        $this->authorize('update', AssetTaking::class);
        $assetTaking->update($request->all());

        $assetTaking->asset()->update([
            'asset_location_id' => $request->asset_location_id,
            'asset_status_id' => $request->asset_status_id,
        ]);

        return $assetTaking;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(AssetTaking $assetTaking)
    {
        $this->authorize('delete', AssetTaking::class);
        return ['success' => $assetTaking->delete()];
    }

    // public function export(Request $request)
    // {
    //     $this->authorize('export', AssetTaking::class);
    //     return Excel::download(new AssetTakingExport($request), 'assets.xlsx');
    // }
}
