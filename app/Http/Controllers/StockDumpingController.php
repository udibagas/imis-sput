<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\StockDumping;
use App\Http\Requests\StockDumpingRequest;
use App\Exports\StockDumpingExport;
use Excel;
use DB;

class StockDumpingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view', StockDumping::class);

        if ($request->ajax())
        {
            $pageSize = $request->rowCount > 0 ? $request->rowCount : 1000000;
            $request['page'] = $request->current;
            $sort = $request->sort ? key($request->sort) : 'stock_dumpings.date';
            $dir = $request->sort ? $request->sort[$sort] : 'desc';

            $stockDumping = StockDumping::selectRaw('
                    stock_dumpings.*,
                    stock_areas.name AS stock_area,
                    areas.name AS block_area,
                    subconts.name AS subcont,
                    subcont_units.code_number AS unit,
                    customers.name AS customer,
                    seams.name AS seam,
                    users.name AS user
                ')
                ->join('subcont_units', 'subcont_units.id', '=', 'stock_dumpings.subcont_unit_id')
                ->join('subconts', 'subconts.id', '=', 'subcont_units.subcont_id')
                ->join('stock_areas', 'stock_areas.id', '=', 'stock_dumpings.stock_area_id')
                ->join('areas', 'areas.id', '=', 'stock_areas.area_id')
                ->join('customers', 'customers.id', '=', 'stock_dumpings.customer_id')
                ->join('users', 'users.id', '=', 'stock_dumpings.user_id')
                ->join('seams', 'seams.id', '=', 'stock_dumpings.seam_id', 'LEFT')
                ->when($request->searchPhrase, function($query) use ($request) {
                    return $query->where('subcont_units.code_number', 'LIKE', '%'.$request->searchPhrase.'%')
                        ->orWhere('stock_dumpings.register_number', 'LIKE', '%'.$request->searchPhrase.'%')
                        ->orWhere('subconts.name', 'LIKE', '%'.$request->searchPhrase.'%')
                        ->orWhere('customers.name', 'LIKE', '%'.$request->searchPhrase.'%')
                        ->orWhere('stock_areas.name', 'LIKE', '%'.$request->searchPhrase.'%');
                })->orderBy($sort, $dir)->paginate($pageSize);

            return [
                'rowCount' => $stockDumping->perPage(),
                'total' => $stockDumping->total(),
                'current' => $stockDumping->currentPage(),
                'rows' => $stockDumping->items(),
            ];
        }

        return view('stockDumping.index', [
            'breadcrumbs' => [
                'operation/dashboard' => 'Operation',
                'stockDumping' => 'Stock Dumping'
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StockDumpingRequest $request)
    {
        $this->authorize('create', StockDumping::class);
        $input = $request->all();
        $input['user_id'] = auth()->user()->id;
        $stockDumping = StockDumping::create($input);


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(StockDumping $stockDumping)
    {
        $this->authorize('view', StockDumping::class);
        return $stockDumping;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StockDumpingRequest $request, StockDumping $stockDumping)
    {
        $this->authorize('update', StockDumping::class);
        $stockDumping->update($request->all());
        return $stockDumping;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(StockDumping $stockDumping)
    {
        $this->authorize('delete', StockDumping::class);
        return ['success' => $stockDumping->delete()];
    }

    public function export(Request $request)
    {
        $this->authorize('export', StockDumping::class);
        return Excel::download(new StockDumpingExport($request), "stock-dumping-{$request->from}-to-{$request->to}.xlsx");
    }

    public function downloadApp()
    {
        return response()->download('imis-checker.apk');
    }

    public function summary(Request $request)
    {
        $from = $request->from ? $request->from : date('Y-m-d');
        $to = $request->to ? $request->to : date('Y-m-d');

        $groupBy = $request->group_by ? $request->group_by : 'customer_id';
        $sql = [];

        $sql['material_type'] = "SELECT
            COUNT(stock_dumpings.id) AS ritase,
            SUM(stock_dumpings.volume) AS tonase,
            IF(stock_dumpings.material_type = 'l', 'LOW', 'HIGH') AS entity
        FROM stock_dumpings
        WHERE stock_dumpings.date BETWEEN ? AND ?
        GROUP BY stock_dumpings.material_type";

        $sql['customer_id'] = "SELECT
            COUNT(stock_dumpings.id) AS ritase,
            SUM(stock_dumpings.volume) AS tonase,
            customers.name AS entity
        FROM stock_dumpings
        JOIN customers ON customers.id = stock_dumpings.customer_id
        WHERE stock_dumpings.date BETWEEN ? AND ?
        GROUP BY stock_dumpings.customer_id";

        $sql['area_id'] = "SELECT
            COUNT(stock_dumpings.id) AS ritase,
            SUM(stock_dumpings.volume) AS tonase,
            areas.name AS entity
        FROM stock_dumpings
        JOIN stock_areas ON stock_areas.id = stock_dumpings.stock_area_id
        JOIN areas ON areas.id = stock_areas.area_id
        WHERE stock_dumpings.date BETWEEN ? AND ?
        GROUP BY stock_areas.area_id";

        $sql['stock_area_id'] = "SELECT
            COUNT(stock_dumpings.id) AS ritase,
            SUM(stock_dumpings.volume) AS tonase,
            stock_areas.name AS entity
        FROM stock_dumpings
        JOIN stock_areas ON stock_areas.id = stock_dumpings.stock_area_id
        WHERE stock_dumpings.date BETWEEN ? AND ?
        GROUP BY stock_dumpings.stock_area_id";

        $sql['subcont_id'] = "SELECT
            COUNT(stock_dumpings.id) AS ritase,
            SUM(stock_dumpings.volume) AS tonase,
            subconts.name AS entity
        FROM stock_dumpings
        JOIN subcont_units ON subcont_units.id = stock_dumpings.subcont_unit_id
        JOIN subconts ON subconts.id = subcont_units.subcont_id
        WHERE stock_dumpings.date BETWEEN ? AND ?
        GROUP BY subcont_units.subcont_id";

        return DB::select($sql[$groupBy], [$from, $to]);
    }

    public function tonase(Request $request)
    {
        $sql = "SELECT COUNT(id) AS ritase, SUM(volume) AS tonase FROM stock_dumpings WHERE `date` BETWEEN ? AND ?";
        return DB::select($sql, [
            $request->from ? $request->from : date("Y-m-d"),
            $request->to ? $request->to : date("Y-m-d")
        ]);
    }

    public function chart(Request $request)
    {
        $from = $request->from ? $request->from : date('Y-m-01');
        $to = $request->to ? $request->to : date('Y-m-d');

        $sql = "SELECT
            `date` AS date,
            COUNT(id) AS ritase,
            SUM(volume) AS tonase
        FROM stock_dumpings
        WHERE `date` BETWEEN ? AND ?
        GROUP BY `date`";

        return DB::select($sql, [$from, $to]);
    }
}
