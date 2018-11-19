<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\AssetCategory;

class AssetCategoryController extends Controller
{
    public function index() {
        return AssetCategory::orderBy('name', 'ASC')->get();
    }
}
