<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\DefaultMaterial;

class DefaultMaterialController extends Controller
{
    public function index() {
        return DefaultMaterial::all();
    }
}
