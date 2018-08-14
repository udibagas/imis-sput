<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\AssetStatus;

class AssetStatusController extends Controller
{
    public function index() {
        return AssetStatus::orderBy('code', 'ASC')->get();
    }
}
