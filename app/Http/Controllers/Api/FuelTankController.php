<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\FuelTank;

class FuelTankController extends Controller
{
    public function index() {
        return FuelTank::all();
    }
}
