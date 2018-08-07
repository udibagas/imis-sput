<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ProductivityPlan;
use App\Http\Requests\ProductivityPlanRequest;

class ProductivityPlanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view', ProductivityPlan::class);

        if ($request->ajax())
        {
            $pageSize = $request->rowCount > 0 ? $request->rowCount : 1000000;
            $request['page'] = $request->current;
            $sort = $request->sort ? key($request->sort) : 'egis.name';
            $dir = $request->sort ? $request->sort[$sort] : 'asc';

            $productivityPlan = ProductivityPlan::selectRaw(' productivity_plans.*, egis.name AS egi')
                ->join('egis', 'egis.id', '=', 'productivity_plans.egi_id')
                ->when($request->searchPhrase, function($query) use ($request) {
                    return $query->where('egis.name', 'LIKE', '%'.$request->searchPhrase.'%');
                })->orderBy($sort, $dir)->paginate($pageSize);

            return [
                'rowCount' => $productivityPlan->perPage(),
                'total' => $productivityPlan->total(),
                'current' => $productivityPlan->currentPage(),
                'rows' => $productivityPlan->items(),
            ];
        }

        return view('productivityPlan.index', [
            'breadcrumbs' => [
                'operation/dashboard' => 'Operation',
                '#' => 'Master Data',
                'productivityPlan' => 'Productivity Plan'
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductivityPlanRequest $request)
    {
        $this->authorize('create', ProductivityPlan::class);
        return ProductivityPlan::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(ProductivityPlan $productivityPlan)
    {
        $this->authorize('view', ProductivityPlan::class);
        return $productivityPlan;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductivityPlanRequest $request, ProductivityPlan $productivityPlan)
    {
        $this->authorize('update', ProductivityPlan::class);
        $productivityPlan->update($request->all());
        return $productivityPlan;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductivityPlan $productivityPlan)
    {
        $this->authorize('delete', ProductivityPlan::class);
        return ['success' => $productivityPlan->delete()];
    }
}
