<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DwellingTimeController extends Controller
{
    public function index()
    {
        return view('dwellingTime.index', [
            'breadcrumbs' => [
                'operation/dashboard' => 'Operation',
                'dwellingTime' => 'Dwelling Time'
            ]
        ]);
    }
}
