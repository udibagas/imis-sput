<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\StockDumping;
use App\MaterialStock;

class StockDumpingController extends Controller
{
    public function index(Request $request)
    {
        return StockDumping::selectRaw('
                stock_dumpings.*,
                areas.name AS area,
                subconts.name AS subcont,
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
            ->where('stock_dumpings.date', date('Y-m-d'))
            ->when($request->customer_id, function($query) use ($request){
                return $query->where('stock_dumpings.customer_id', $request->customer_id);
            })->orderBy('stock_dumpings.id', 'DESC')->get();
    }

    public function store(Request $request)
    {
        $rows = json_decode($request->rows);

        foreach($rows as $r)
        {
            $data = [
                'date'              => $r->date,
                'shift'             => $r->shift,
                'time'              => $r->time,
                'subcont_unit_id'   => $r->subcont_unit_id,
                'stock_area_id'     => $r->stock_area_id,
                'customer_id'       => $r->customer_id,
                'material_type'     => $r->material_type,
                'seam_id'           => $r->seam_id,
                'volume'            => $r->volume,
                'register_number'   => $r->register_number,
                'user_id'      	    => $r->user_id,
                'insert_via'        => 'mobile'
            ];

            // check duplikasi
            $exists = StockDumping::where('date', $r->date)
                ->where('shift', $r->shift)
                ->where('stock_area_id', $r->stock_area_id)
                ->where('subcont_unit_id', $r->subcont_unit_id)
                ->where('customer_id', $r->customer_id)
                ->where('volume', $r->volume)
                ->first();

            if ($exists) {
                continue;
            }

            $stockDumping = StockDumping::create($data);

            $stock = MaterialStock::where('customer_id', $r->customer_id)
                ->where('contractor_id', $r->contractor_id)
                ->where('stock_area_id', $r->stock_area_id)
                ->where('seam_id', $r->seam_id)
                ->where('material_type', $r->material_type)
                ->first();

            if ($stock) {
                $stock->update([
                    'volume' => $stock->volume + ($r->volume/1000),
                    'dumping_date' => $stockDumping->date
                ]);
            }

            else {
                MaterialStock::create([
                    'customer_id' => $r->customer_id,
                    'contractor_id' => $r->contractor_id,
                    'stock_area_id' => $r->stock_area_id,
                    'seam_id' => $r->seam_id,
                    'material_type' => $r->material_type,
                    'volume' => $r->volume/1000,
                    'dumping_date' => $r->date
                ]);
            }
        }

        return json_encode(['success' => true]);
    }
}
