<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HcgsController extends Controller
{
    public function index()
    {
        return view('hcgs.index', [
            'breadcrumbs' => [
                'hcgs' => 'HCGS',
                '#' => 'Dashboard',
            ]
        ]);
    }
}
