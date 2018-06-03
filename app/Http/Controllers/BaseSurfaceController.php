<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\BaseSurface;

class BaseSurfaceController extends Controller
{
    public function index(Request $request)
    {
        $date = $request->date ? $request->date : date('Y-m-d');

        return BaseSurface::selectRaw("DATEPART(HOUR, StampDate) AS hour, AVG(Surface) AS surface")
            ->whereRaw("DATE(StampDate) = '$date'")
            ->orderBy('StampDate', 'DESC')
            ->groupBy('hour')
            ->get();
    }
}
