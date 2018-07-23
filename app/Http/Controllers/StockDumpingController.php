<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\StockDumping;
use App\Http\Requests\StockDumpingRequest;
use App\Exports\StockDumpingExport;
use Excel;

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
                    CONCAT("Jetty ", jetties.name, " - ", stock_areas.name) AS area,
                    CONCAT(armadas.name, " - ", armada_units.name) AS unit,
                    customers.name AS customer,
                    seams.name AS seam,
                    users.name AS user
                ')
                ->join('armada_units', 'armada_units.id', '=', 'stock_dumpings.armada_unit_id')
                ->join('armadas', 'armadas.id', '=', 'armada_units.armada_id')
                ->join('stock_areas', 'stock_areas.id', '=', 'stock_dumpings.stock_area_id')
                ->join('jetties', 'jetties.id', '=', 'stock_areas.jetty_id')
                ->join('customers', 'customers.id', '=', 'stock_dumpings.customer_id')
                ->join('users', 'users.id', '=', 'stock_dumpings.user_id')
                ->join('seams', 'seams.id', '=', 'stock_dumpings.seam_id', 'LEFT')
                ->when($request->searchPhrase, function($query) use ($request) {
                    return $query->where('armada_units.name', 'LIKE', '%'.$request->searchPhrase.'%')
                        ->where('customers.name', 'LIKE', '%'.$request->searchPhrase.'%')
                        ->where('stock_areas.name', 'LIKE', '%'.$request->searchPhrase.'%');
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
}
