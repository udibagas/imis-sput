<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Area;

class OperationController extends Controller
{
    public function waterLevel()
    {
        return view('operation.waterLevel', [
            'breadcrumbs' => [
                'operation' => 'Operation',
                'waterLevel' => 'Water Level'
            ]
        ]);
    }

    public function stockBalanced()
    {
        return view('operation.stockBalanced', [
            'breadcrumbs' => [
                'operation' => 'Operation',
                'stockBalanced' => 'Stock Balanced'
            ]
        ]);
    }

    public function productivityJetty()
    {
        return view('operation.pasangSurut', [
            'breadcrumbs' => [
                'operation/dashboard' => 'Operation',
                '#' => 'Hourly Monitoring Barging',
                'pasangSurut' => 'Prediksi Pasang Surut'
            ]
        ]);
    }

    public function index()
    {
        return view('operation.dashboard', [
            'areas' => Area::selectRaw('areas.*, jetties.name AS jetty')
                ->join('jetties', 'jetties.id', '=', 'areas.jetty_id', 'LEFT')
                ->orderBy('jetties.order', 'ASC')->get(),
            'breadcrumbs' => [
                'operation/dashboard' => 'Operation',
                'dashboard' => 'Dashboard'
            ]
        ]);
    }
}
