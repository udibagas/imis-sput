<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\AssetTaking;
use App\Http\Requests\AssetTakingRequest;

class AssetTakingController extends Controller
{
    public function index() {
        return AssetTaking::orderBy('date', 'desc')->get();
    }

    public function store(AssetTakingRequest $request)
    {
        $assetTaking = AssetTaking::create($request->all());
        $assetTaking->asset()->update([
            'asset_location_id' => $request->new_asset_location_id,
            'asset_status_id' => $request->new_asset_status_id,
        ]);

        return $assetTaking;
    }

}
