<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\BargingPlan;
use App\Http\Requests\BargingPlanRequest;
use App\Barge;

class BargingPlanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return BargingPlan::whereBetween('date', [$request->start, $request->end])
                ->orderBy('date', 'ASC')->get();
        }

        return view('bargingPlan.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        foreach ($request->plans as $p) {
            foreach ($p['plans'] as $customer_id => $volume) {
                if ($volume == null) {
                    continue;
                }
                
                $plan = BargingPlan::where('date', $p['date'])
                    ->where('customer_id', $customer_id)
                    ->first();
                
                if ($plan) {
                    $plan->update(['volume' => $volume]);
                } else {
                    BargingPlan::create([
                        'date' => $p['date'],
                        'customer_id' => $customer_id,
                        'volume' => $volume
                    ]);
                }
            }
        }

        return BargingPlan::whereBetween('date', [$request->start, $request->end])
            ->orderBy('date', 'ASC')->get(); 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BargingPlanRequest $request, BargingPlan $bargingPlan)
    {
        $bargingPlan->update($request->all());
        return $bargingPlan;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(BargingPlan $bargingPlan)
    {
        return ['status' => $bargingPlan->delete()];
    }
}
