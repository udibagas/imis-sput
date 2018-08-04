<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MaterialStock;
use App\Http\Requests\MaterialStockRequest;
use DB;

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
                    areas.name AS area,
                    stock_areas.name AS stock_area,
                    customers.name AS customer,
                    seams.name AS seam
                ')
                ->join('stock_areas', 'stock_areas.id', '=', 'material_stocks.stock_area_id')
                ->join('areas', 'areas.id', '=', 'stock_areas.area_id')
                ->join('customers', 'customers.id', '=', 'material_stocks.customer_id')
                ->join('seams', 'seams.id', '=', 'material_stocks.seam_id', 'LEFT')
                ->when($request->searchPhrase, function($query) use ($request) {
                    return $query->where('customers.name', 'LIKE', '%'.$request->searchPhrase.'%')
                        ->orWhere('stock_areas.name', 'LIKE', '%'.$request->searchPhrase.'%')
                        ->orWhere('areas.name', 'LIKE', '%'.$request->searchPhrase.'%')
                        ->orWhere('customers.name', 'LIKE', '%'.$request->searchPhrase.'%');
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
                'materialStock' => 'Stock Balanced'
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

    public function summary(Request $request)
    {
        $groupBy = $request->group_by ? $request->group_by : 'customer_id';
        $condition = '';

        if ($request->customer_id) {
            $condition = "WHERE customer_id = ".$request->customer_id;
        }

        $sql = [];

        $sql['material_type'] = "SELECT
            SUM(material_stocks.volume) AS volume,
            IF(material_stocks.material_type = 'l', 'LOW', 'HIGH') AS entity
        FROM material_stocks
        ".$condition."
        GROUP BY material_stocks.material_type";

        $sql['seam_id'] = "SELECT
            SUM(material_stocks.volume) AS volume,
            seams.name AS entity
        FROM material_stocks
        JOIN seams ON seams.id = material_stocks.seam_id
        ".$condition."
        GROUP BY material_stocks.seam_id";

        $sql['customer_id'] = "SELECT
            SUM(material_stocks.volume) AS volume,
            customers.name AS entity
        FROM material_stocks
        JOIN customers ON customers.id = material_stocks.customer_id
        ".$condition."
        GROUP BY material_stocks.customer_id";

        $sql['area_id'] = "SELECT
            SUM(material_stocks.volume) AS volume,
            areas.name AS entity
        FROM material_stocks
        JOIN stock_areas ON stock_areas.id = material_stocks.stock_area_id
        JOIN areas ON areas.id = stock_areas.area_id
        ".$condition."
        GROUP BY stock_areas.area_id";

        $sql['stock_area_id'] = "SELECT
            SUM(material_stocks.volume) AS volume,
            CONCAT(areas.name, ' - ', stock_areas.name) AS entity
        FROM material_stocks
        JOIN stock_areas ON stock_areas.id = material_stocks.stock_area_id
        JOIN areas ON areas.id = stock_areas.area_id
        ".$condition."
        GROUP BY material_stocks.stock_area_id";

        return DB::select($sql[$groupBy]);
    }
}
