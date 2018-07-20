<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MaterialStock;
use App\Http\Requests\MaterialStockRequest;

class MaterialStockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view', MaterialStock::class);

        if ($request->ajax())
        {
            $pageSize = $request->rowCount > 0 ? $request->rowCount : 1000000;
            $request['page'] = $request->current;
            $sort = $request->sort ? key($request->sort) : 'material_stocks.dumping_date';
            $dir = $request->sort ? $request->sort[$sort] : 'desc';

            $materialStock = MaterialStock::selectRaw('
                    material_stocks.*,
                    CONCAT("Jetty ", jetties.name, " - ", stock_areas.name) AS area,
                    customers.name AS customer,
                    seams.name AS seam
                ')
                ->join('stock_areas', 'stock_areas.id', '=', 'material_stocks.stock_area_id')
                ->join('jetties', 'jetties.id', '=', 'stock_areas.jetty_id')
                ->join('customers', 'customers.id', '=', 'material_stocks.customer_id')
                ->join('seams', 'seams.id', '=', 'material_stocks.seam_id', 'LEFT')
                ->when($request->searchPhrase, function($query) use ($request) {
                    return $query->where('customers.name', 'LIKE', '%'.$request->searchPhrase.'%')
                        ->where('stock_areas.name', 'LIKE', '%'.$request->searchPhrase.'%');
                })->orderBy($sort, $dir)->paginate($pageSize);

            return [
                'rowCount' => $materialStock->perPage(),
                'total' => $materialStock->total(),
                'current' => $materialStock->currentPage(),
                'rows' => $materialStock->items(),
            ];
        }

        return view('materialStock.index', [
            'breadcrumbs' => [
                'operation/dashboard' => 'Operation',
                'materialStock' => 'Stock Dumping'
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MaterialStockRequest $request)
    {
        $this->authorize('create', MaterialStock::class);
        return MaterialStock::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(MaterialStock $materialStock)
    {
        $this->authorize('view', MaterialStock::class);
        return $materialStock;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(MaterialStockRequest $request, MaterialStock $materialStock)
    {
        $this->authorize('update', MaterialStock::class);
        $materialStock->update($request->all());
        return $materialStock;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(MaterialStock $materialStock)
    {
        $this->authorize('delete', MaterialStock::class);
        return ['success' => $materialStock->delete()];
    }
}
