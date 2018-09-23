<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Asset;

class AssetController extends Controller
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
    
    public function index(Request $request)
    {
        try {
            $asset = Asset::selectRaw("
                    assets.*,
                    asset_locations.name AS location,
                    CONCAT(asset_statuses.code, ' - ', asset_statuses.description) AS stts
                ")
                ->join('asset_locations', 'asset_locations.id', '=', 'assets.asset_location_id')
                ->join('asset_statuses', 'asset_statuses.id', '=', 'assets.asset_status_id')
                ->where('assets.reg_no', $request->reg_no)->first();
        } catch (\Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }

        return ['status' => 'success', 'asset' => $asset];
    }
}
