<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Barge;

class BargeController extends Controller
{
    public function index() {
        return Barge::all();
    }
}
