<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Asset;

class AssetController extends Controller
{
    public function index() {
        return Asset::orderBy('reg_no', 'ASC')->get();
    }

    public function show(Asset $asset) {
        return $asset;
    }
}
