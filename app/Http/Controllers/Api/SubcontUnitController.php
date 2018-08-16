<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\SubcontUnit;

class SubcontUnitController extends Controller
{
    public function index() {
        return SubcontUnit::selectRaw('subcont_units.*, subconts.name AS subcont')
            ->join('subconts', 'subconts.id', '=', 'subcont_units.subcont_id')
            ->orderBy('subcont_units.code_number', 'ASC')
            ->get();
    }
}
