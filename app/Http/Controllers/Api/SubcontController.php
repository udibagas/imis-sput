<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Subcont;

class SubcontController extends Controller
{
    public function index() {
        return Subcont::all();
    }
}
