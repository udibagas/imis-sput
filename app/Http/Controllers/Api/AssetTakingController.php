<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\AssetTaking;
use App\Http\Requests\AssetTakingRequest;

class AssetTakingController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index() {
        return AssetTaking::orderBy('date', 'desc')->get();
    }

    public function store(AssetTakingRequest $request)
    {
        $input = $request->all();
        $input['user_id'] = $request->user()->id;
        $assetTaking = AssetTaking::create($input);
        $assetTaking->asset()->update([
            'asset_location_id' => $request->new_asset_location_id,
            'asset_status_id' => $request->new_asset_status_id,
        ]);

        return $assetTaking;
    }

}
