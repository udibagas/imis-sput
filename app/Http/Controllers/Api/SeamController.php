<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Seam;

class SeamController extends Controller
{
    public function index() {
        return Seam::all();
    }
}
