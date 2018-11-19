<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\AssetVendor;

class AssetVendorController extends Controller
{
    public function index() {
        return AssetVendor::orderBy('name', 'ASC')->get();
    }
}
