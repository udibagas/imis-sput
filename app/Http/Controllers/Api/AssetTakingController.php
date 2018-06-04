<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\AssetTaking;
use App\Http\Requests\AssetTakingRequest;

class AssetTakingController extends Controller
{
    public function index() {
        return AssetTaking::orderBy('date', 'desc')->get();
    }

    public function store(AssetTakingRequest $request) {
        return AssetTaking::create($request->all());
    }

}
