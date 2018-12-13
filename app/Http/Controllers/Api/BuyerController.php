<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Buyer;

class BuyerController extends Controller
{
    public function index() {
        return Buyer::orderBy('name', 'ASC')->get();
    }
}
