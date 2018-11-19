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
        // $this->middleware('auth:api');
    }

    public function index(Request $request)
    {
        return Asset::join('asset_locations', 'asset_locations.id', '=', 'assets.asset_location_id')
            ->join('asset_statuses', 'asset_statuses.id', '=', 'assets.asset_status_id')
            ->join('asset_categories', 'asset_categories.id', '=', 'assets.asset_category_id', 'LEFT')
            ->join('asset_vendors', 'asset_vendors.id', '=', 'assets.asset_vendor_id', 'LEFT')
            ->where('assets.reg_no', $request->reg_no)
            ->with(['assetLocation', 'assetStatus', 'assetVendor', 'assetCategory'])
            ->first();
    }

    public function update(Asset $asset, Request $request)
    {
        $asset->update($request->all());
        return $asset;
    }

    public function uploadPicture(Request $request)
    {
        if ($request->hasFile('file'))
        {
            $file = $request->file('file');
            $fileName = time().$file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();

            if (!in_array(strtolower($extension), ['png', 'jpg', 'jpeg', 'bmp']))
            {
                return [
                    'success' => false,
                    'message' => 'File extension not permitted'
                ];
            }

            try {
                $file->move('images/', $fileName);
            } catch (\Exception $e) {
                return [
                    'success' => false,
                    'message' => 'Failed to move file'
                ];
            }

            $asset = Asset::find($request->asset_id);

            if ($asset)
            {
                if ($asset->picture && file_exists($asset->picture)) {
                    unlink($asset->picture);
                }

                $asset->picture = 'images/'.$fileName;
                $asset->save();
            }

            return [
                'success' => true,
                'file' => 'images/'.$fileName,
                'message' => 'Picture has been updated!'
            ];
        }

        return ['success' => false, 'message' => 'No file uploaded'];
    }
}
