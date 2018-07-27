<?php

namespace App\Http\Controllers;
use Artisan;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function update()
    {
        return view('admin.update');
    }

    public function doUpdate()
    {
        return Artisan::call('update');
    }
}
