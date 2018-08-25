<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Jetty;

class JettyController extends Controller
{
    public function index() {
        return Jetty::orderBy('order', 'ASC')->get();
    }
}
