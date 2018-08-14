<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Area;

class AreaController extends Controller
{
    public function index() {
        return Area::all();
    }
}
