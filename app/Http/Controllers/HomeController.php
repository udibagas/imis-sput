<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        if (auth()->user()->customer_id) {
            return view('customer.dashboard');
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
