<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OperationController extends Controller
{
    public function pasangSurut()
    {
        return view('operation.pasangSurut', [
            'breadcrumbs' => [
                'operation/dashboard' => 'Operation',
                '#' => 'Hourly Monitoring Barging',
                'pasangSurut' => 'Prediksi Pasang Surut'
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



    public function dashboard()
    {
        return view('operation.dashboard', [
            'breadcrumbs' => [
                'operation/dashboard' => 'Operation',
                'dashboard' => 'Dashboard'
            ]
        ]);
    }
}
