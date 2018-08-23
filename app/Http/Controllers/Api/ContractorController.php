<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Contractor;

class ContractorController extends Controller
{
    public function index() {
        return Contractor::all();
    }
}
