<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jetty;

class OperationController extends Controller
{
    public function index()
    {
        return view('operation.dashboard', [
            'jetties' => Jetty::all(),
            'breadcrumbs' => [
                'operation' => 'Operation',
                'dashboard' => 'Dashboard'
            ]
        ]);
    }
    
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

}
