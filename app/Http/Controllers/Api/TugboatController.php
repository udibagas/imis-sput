<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Tugboat;

class TugboatController extends Controller
{
    public function index() {
        return Tugboat::all();
    }
}
