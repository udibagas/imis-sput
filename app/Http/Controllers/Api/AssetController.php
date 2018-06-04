<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Asset;

class AssetController extends Controller
{
    public function show(Asset $asset) {
        return $asset;
    }
}
