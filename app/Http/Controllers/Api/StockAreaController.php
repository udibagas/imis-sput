<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\StockArea;

class StockAreaController extends Controller
{
    public function index() {
        return StockArea::all();
    }
}
