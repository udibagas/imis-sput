<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // if (auth()->user()->customer_id) {
        //     return view('customer.dashboard');
        // }

        if (auth()->user()->customer_id || auth()->user()->contractor_id)
        {
            return view('stockDumping.summary', [
                'breadcrumbs' => [
                    'operation' => 'Operation',
                    'stockDumping/summary' => 'Stock Dumping Summary'
                ]
            ]);
        }

        return view('home', [
            'breadcrumbs' => []
        ]);
    }

    public function registerOk() {
        return view('auth.register_ok');
    }

    public function registerFailed() {
        return view('auth.register_failed');
    }
}
