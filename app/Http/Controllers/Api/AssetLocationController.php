<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\AssetLocation;

class AssetLocationController extends Controller
{
    public function index() {
        return AssetLocation::orderBy('name', 'ASC')->get();
    }
}
