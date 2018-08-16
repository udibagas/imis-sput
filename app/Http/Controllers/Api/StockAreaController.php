<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\StockArea;

class StockAreaController extends Controller
{
    public function index() {
        return StockArea::selectRaw('stock_areas.*, areas.name AS area')
            ->join('areas', 'areas.id', '=', 'stock_areas.area_id')
            ->orderBy('stock_areas.name', 'ASC')
            ->get();
    }
}
