<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Prajobs;
use App\Http\Requests\PrajobsRequest;

class PrajobsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view', Prajobs::class);
        return Prajobs::orderBy('created_at', 'ASC')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PrajobsRequest $request)
    {
        return Prajobs::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Prajobs $prajob)
    {
        $this->authorize('view', Prajobs::class);
        return $prajob;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PrajobsRequest $request, Prajobs $prajob)
    {
        $prajob->update($request->all());
        return $prajob;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Prajobs $prajob)
    {
        $this->authorize('delete', Prajobs::class);
        return ['success' => $prajob->delete()];
    }
}
