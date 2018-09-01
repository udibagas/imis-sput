<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\StockDumping;
use App\MaterialStock;
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
                    stock_areas.name AS sa,
                    areas.name AS block_area,
                    subconts.name AS subcont,
                    subcont_units.code_number AS unit,
                    customers.name AS customer,
                    contractors.name AS contractor,
                    seams.name AS seam,
                    users.name AS user
                ')
                ->join('subcont_units', 'subcont_units.id', '=', 'stock_dumpings.subcont_unit_id')
                ->join('subconts', 'subconts.id', '=', 'subcont_units.subcont_id')
                ->join('stock_areas', 'stock_areas.id', '=', 'stock_dumpings.stock_area_id')
                ->join('areas', 'areas.id', '=', 'stock_areas.area_id')
                ->join('customers', 'customers.id', '=', 'stock_dumpings.customer_id')
                ->join('contractors', 'contractors.id', '=', 'stock_dumpings.contractor_id')
                ->join('users', 'users.id', '=', 'stock_dumpings.user_id')
                ->join('seams', 'seams.id', '=', 'stock_dumpings.seam_id', 'LEFT')
                ->when(auth()->user()->customer_id, function($query) {
                    return $query->where('stock_dumpings.customer_id', auth()->user()->customer_id);
                })
                ->when(auth()->user()->contractor_id, function($query) {
                    return $query->where('stock_dumpings.contractor_id', auth()->user()->contractor_id);
                })
                ->when($request->searchPhrase, function($query) use ($request) {
                    return $query->where('subcont_units.code_number', 'LIKE', '%'.$request->searchPhrase.'%')
                        ->orWhere('stock_dumpings.register_number', 'LIKE', '%'.$request->searchPhrase.'%')
                        ->orWhere('subconts.name', 'LIKE', '%'.$request->searchPhrase.'%')
                        ->orWhere('customers.name', 'LIKE', '%'.$request->searchPhrase.'%')
                        ->orWhere('contractors.name', 'LIKE', '%'.$request->searchPhrase.'%')
                        ->orWhere('stock_areas.name', 'LIKE', '%'.$request->searchPhrase.'%');
                })->orderBy($sort, $dir)->orderBy('stock_dumpings.time', 'DESC')->paginate($pageSize);

            return [
                'rowCount' => $stockDumping->perPage(),
                'total' => $stockDumping->total(),
                'current' => $stockDumping->currentPage(),
                'rows' => $stockDumping->items(),
            ];
        }

        return view('stockDumping.index', [
            'breadcrumbs' => [
                'operation' => 'Operation',
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

        $stock = MaterialStock::where('customer_id', $request->customer_id)
            ->where('contractor_id', $request->contractor_id)
            ->where('stock_area_id', $request->stock_area_id)
            ->where('seam_id', $request->seam_id)
            ->where('material_type', $request->material_type)
            ->first();

        if ($stock) {
            $stock->update([
                'volume' => $stock->volume + ($request->volume/1000),
                'dumping_date' => $stockDumping->date
            ]);
        }

        else {
            MaterialStock::create([
                'customer_id' => $request->customer_id,
                'contractor_id' => $request->contractor_id,
                'stock_area_id' => $request->stock_area_id,
                'seam_id' => $request->seam_id,
                'material_type' => $request->material_type,
                'volume' => $request->volume/1000,
                'dumping_date' => $request->date
            ]);
        }
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
        $oldVolume = $stockDumping->volume;
        $stockDumping->update($request->all());
        $newVolume = $stockDumping->volume;

        $stock = MaterialStock::where('customer_id', $request->customer_id)
            ->where('contractor_id', $request->contractor_id)
            ->where('stock_area_id', $request->stock_area_id)
            ->where('seam_id', $request->seam_id)
            ->where('material_type', $request->material_type)
            ->first();

        if ($stock) {
            $stock->update([
                'volume' => $stock->volume + (($newVolume - $oldVolume) / 1000),
                'dumping_date' => $request->date
            ]);
        }

        else {
            MaterialStock::create([
                'customer_id' => $request->customer_id,
                'contractor_id' => $request->contractor_id,
                'stock_area_id' => $request->stock_area_id,
                'seam_id' => $request->seam_id,
                'material_type' => $request->material_type,
                'volume' => $request->volume/1000,
                'dumping_date' => $request->date
            ]);
        }

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
        if (!$request->ajax())
        {
            return view('stockDumping.summary', [
                'breadcrumbs' => [
                    'operation' => 'Operation',
                    'stockDumping/summary' => 'Stock Dumping Summary'
                ]
            ]);
        }

        $from = $request->from ? $request->from : date('Y-m-d');
        $to = $request->to ? $request->to : date('Y-m-d');

        $groupBy = $request->group_by ? $request->group_by : 'customer_id';
        $sql = [];

        $condition = "1 = 1";

        if (auth()->user()->customer_id) {
            $condition = "stock_dumpings.customer_id = ".auth()->user()->customer_id;
        }

        if (auth()->user()->contractor_id) {
            $condition = "stock_dumpings.contractor_id = ".auth()->user()->contractor_id;
        }

        $sql['material_type'] = "SELECT
            COUNT(id) AS ritase,
            SUM(shift = 1) AS ritase_1,
            SUM(shift = 2) AS ritase_2,
            SUM(CASE WHEN shift = 1 THEN volume ELSE 0 END) AS tonase_1,
            SUM(CASE WHEN shift = 2 THEN volume ELSE 0 END) AS tonase_2,
            SUM(volume) AS tonase,
            COUNT(DISTINCT subcont_unit_id) AS unit,
            COUNT(DISTINCT CASE WHEN shift = 1 THEN subcont_unit_id END) AS unit_1,
            COUNT(DISTINCT CASE WHEN shift = 2 THEN subcont_unit_id END) AS unit_2,
            IF(material_type = 'l', 'LOW', 'HIGH') AS entity
        FROM stock_dumpings
        WHERE date BETWEEN ? AND ?
            AND $condition
        GROUP BY material_type";

        $sql['customer_id'] = "SELECT
            COUNT(stock_dumpings.id) AS ritase,
            SUM(stock_dumpings.shift = 1) AS ritase_1,
            SUM(stock_dumpings.shift = 2) AS ritase_2,
            SUM(CASE WHEN stock_dumpings.shift = 1 THEN stock_dumpings.volume ELSE 0 END) AS tonase_1,
            SUM(CASE WHEN stock_dumpings.shift = 2 THEN stock_dumpings.volume ELSE 0 END) AS tonase_2,
            SUM(stock_dumpings.volume) AS tonase,
            COUNT(DISTINCT stock_dumpings.subcont_unit_id) AS unit,
            COUNT(DISTINCT CASE WHEN stock_dumpings.shift = 1 THEN stock_dumpings.subcont_unit_id END) AS unit_1,
            COUNT(DISTINCT CASE WHEN stock_dumpings.shift = 2 THEN stock_dumpings.subcont_unit_id END) AS unit_2,
            customers.name AS entity
        FROM stock_dumpings
        JOIN customers ON customers.id = stock_dumpings.customer_id
        WHERE stock_dumpings.date BETWEEN ? AND ?
            AND $condition
        GROUP BY stock_dumpings.customer_id";

        $sql['contractor_id'] = "SELECT
            COUNT(stock_dumpings.id) AS ritase,
            SUM(stock_dumpings.shift = 1) AS ritase_1,
            SUM(stock_dumpings.shift = 2) AS ritase_2,
            SUM(stock_dumpings.volume) AS tonase,
            SUM(CASE WHEN stock_dumpings.shift = 1 THEN stock_dumpings.volume ELSE 0 END) AS tonase_1,
            SUM(CASE WHEN stock_dumpings.shift = 2 THEN stock_dumpings.volume ELSE 0 END) AS tonase_2,
            COUNT(DISTINCT stock_dumpings.subcont_unit_id) AS unit,
            COUNT(DISTINCT CASE WHEN stock_dumpings.shift = 1 THEN stock_dumpings.subcont_unit_id END) AS unit_1,
            COUNT(DISTINCT CASE WHEN stock_dumpings.shift = 2 THEN stock_dumpings.subcont_unit_id END) AS unit_2,
            contractors.name AS entity
        FROM stock_dumpings
        JOIN contractors ON contractors.id = stock_dumpings.contractor_id
        WHERE stock_dumpings.date BETWEEN ? AND ?
            AND $condition
        GROUP BY stock_dumpings.contractor_id";

        $sql['seam_id'] = "SELECT
            COUNT(stock_dumpings.id) AS ritase,
            SUM(stock_dumpings.shift = 1) AS ritase_1,
            SUM(stock_dumpings.shift = 2) AS ritase_2,
            SUM(stock_dumpings.volume) AS tonase,
            SUM(CASE WHEN stock_dumpings.shift = 1 THEN stock_dumpings.volume ELSE 0 END) AS tonase_1,
            SUM(CASE WHEN stock_dumpings.shift = 2 THEN stock_dumpings.volume ELSE 0 END) AS tonase_2,
            COUNT(DISTINCT stock_dumpings.subcont_unit_id) AS unit,
            COUNT(DISTINCT CASE WHEN stock_dumpings.shift = 1 THEN stock_dumpings.subcont_unit_id END) AS unit_1,
            COUNT(DISTINCT CASE WHEN stock_dumpings.shift = 2 THEN stock_dumpings.subcont_unit_id END) AS unit_2,
            seams.name AS entity
        FROM stock_dumpings
        LEFT JOIN seams ON seams.id = stock_dumpings.seam_id
        WHERE stock_dumpings.date BETWEEN ? AND ?
            AND $condition
        GROUP BY stock_dumpings.seam_id";

        $sql['area_id'] = "SELECT
            COUNT(stock_dumpings.id) AS ritase,
            SUM(stock_dumpings.shift = 1) AS ritase_1,
            SUM(stock_dumpings.shift = 2) AS ritase_2,
            SUM(stock_dumpings.volume) AS tonase,
            SUM(CASE WHEN stock_dumpings.shift = 1 THEN stock_dumpings.volume ELSE 0 END) AS tonase_1,
            SUM(CASE WHEN stock_dumpings.shift = 2 THEN stock_dumpings.volume ELSE 0 END) AS tonase_2,
            COUNT(DISTINCT stock_dumpings.subcont_unit_id) AS unit,
            COUNT(DISTINCT CASE WHEN stock_dumpings.shift = 1 THEN stock_dumpings.subcont_unit_id END) AS unit_1,
            COUNT(DISTINCT CASE WHEN stock_dumpings.shift = 2 THEN stock_dumpings.subcont_unit_id END) AS unit_2,
            areas.name AS entity
        FROM stock_dumpings
        JOIN stock_areas ON stock_areas.id = stock_dumpings.stock_area_id
        JOIN areas ON areas.id = stock_areas.area_id
        WHERE stock_dumpings.date BETWEEN ? AND ?
            AND $condition
        GROUP BY stock_areas.area_id";

        $sql['stock_area_id'] = "SELECT
            COUNT(stock_dumpings.id) AS ritase,
            SUM(stock_dumpings.shift = 1) AS ritase_1,
            SUM(stock_dumpings.shift = 2) AS ritase_2,
            SUM(stock_dumpings.volume) AS tonase,
            SUM(CASE WHEN stock_dumpings.shift = 1 THEN stock_dumpings.volume ELSE 0 END) AS tonase_1,
            SUM(CASE WHEN stock_dumpings.shift = 2 THEN stock_dumpings.volume ELSE 0 END) AS tonase_2,
            COUNT(DISTINCT stock_dumpings.subcont_unit_id) AS unit,
            COUNT(DISTINCT CASE WHEN stock_dumpings.shift = 1 THEN stock_dumpings.subcont_unit_id END) AS unit_1,
            COUNT(DISTINCT CASE WHEN stock_dumpings.shift = 2 THEN stock_dumpings.subcont_unit_id END) AS unit_2,
            stock_areas.name AS entity
        FROM stock_dumpings
        JOIN stock_areas ON stock_areas.id = stock_dumpings.stock_area_id
        WHERE stock_dumpings.date BETWEEN ? AND ?
            AND $condition
        GROUP BY stock_dumpings.stock_area_id";

        $sql['subcont_id'] = "SELECT
            COUNT(stock_dumpings.id) AS ritase,
            SUM(stock_dumpings.shift = 1) AS ritase_1,
            SUM(stock_dumpings.shift = 2) AS ritase_2,
            SUM(stock_dumpings.volume) AS tonase,
            SUM(CASE WHEN stock_dumpings.shift = 1 THEN stock_dumpings.volume ELSE 0 END) AS tonase_1,
            SUM(CASE WHEN stock_dumpings.shift = 2 THEN stock_dumpings.volume ELSE 0 END) AS tonase_2,
            COUNT(DISTINCT stock_dumpings.subcont_unit_id) AS unit,
            COUNT(DISTINCT CASE WHEN stock_dumpings.shift = 1 THEN stock_dumpings.subcont_unit_id END) AS unit_1,
            COUNT(DISTINCT CASE WHEN stock_dumpings.shift = 2 THEN stock_dumpings.subcont_unit_id END) AS unit_2,
            subconts.name AS entity
        FROM stock_dumpings
        JOIN subcont_units ON subcont_units.id = stock_dumpings.subcont_unit_id
        JOIN subconts ON subconts.id = subcont_units.subcont_id
        WHERE stock_dumpings.date BETWEEN ? AND ?
            AND $condition
        GROUP BY subcont_units.subcont_id";

        return DB::select($sql[$groupBy], [$from, $to]);
    }

    public function tonase(Request $request)
    {
        $condition ="1 = 1";

        if (auth()->user()->customer_id) {
            $condition = "stock_dumpings.customer_id = ".auth()->user()->customer_id;
        }

        if (auth()->user()->contractor_id) {
            $condition = "stock_dumpings.contractor_id = ".auth()->user()->contractor_id;
        }

        $sql = "SELECT
                COUNT(id) AS ritase,
                SUM(shift = 1) AS ritase_1,
                SUM(shift = 2) AS ritase_2,
                SUM(volume) AS tonase,
                SUM(CASE WHEN shift = 1 THEN volume ELSE 0 END) AS tonase_1,
                SUM(CASE WHEN shift = 2 THEN volume ELSE 0 END) AS tonase_2,
                COUNT(DISTINCT subcont_unit_id) AS unit,
                COUNT(DISTINCT CASE WHEN shift = 1 THEN subcont_unit_id END) AS unit_1,
                COUNT(DISTINCT CASE WHEN shift = 2 THEN subcont_unit_id END) AS unit_2
            FROM stock_dumpings
            WHERE `date` BETWEEN ? AND ? AND $condition";

        return DB::select($sql, [
            $request->from ? $request->from : date("Y-m-d"),
            $request->to ? $request->to : date("Y-m-d")
        ]);
    }

    public function chart(Request $request)
    {
        $from = $request->from ? $request->from : date('Y-m-01');
        $to = $request->to ? $request->to : date('Y-m-d');

        $condition = "1 = 1";

        if (auth()->user()->customer_id) {
            $condition = "stock_dumpings.customer_id = ".auth()->user()->customer_id;
        }

        if (auth()->user()->contractor_id) {
            $condition = "stock_dumpings.contractor_id = ".auth()->user()->contractor_id;
        }

        $sql = "SELECT
            `date` AS date,
            COUNT(id) AS ritase,
            SUM(volume) AS tonase
        FROM stock_dumpings
        WHERE `date` BETWEEN ? AND ? AND $condition
        GROUP BY `date`";

        return DB::select($sql, [$from, $to]);
    }
}
