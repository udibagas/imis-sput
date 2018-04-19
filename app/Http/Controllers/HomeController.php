<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
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
