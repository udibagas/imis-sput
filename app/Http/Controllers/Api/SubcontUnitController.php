<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\SubcontUnit;

class SubcontUnitController extends Controller
{
    public function index() {
        return SubcontUnit::all();
    }
}
