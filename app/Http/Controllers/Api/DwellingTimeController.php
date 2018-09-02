<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\DwellingTime;

class DwellingTimeController extends Controller
{
    public function index(Request $request)
    {
        return DwellingTime::selectRaw('
                dwelling_times.*,
                jetties.name AS jetty,
                customers.name AS customer
            ')
            ->join('bargings', 'bargings.id', '=', 'dwelling_times.barging_id')
            ->join('jetties', 'jetties.id', '=', 'dwelling_times.jetty_id')
            ->join('customers', 'customers.id', '=', 'bargings.customer_id')
            ->when($request->barging_id, function($query) use ($request) {
                return $query->where('dwelling_times.barging_id', $request->barging_id);
            })->orderBy('dwelling_times.id', 'DESC')->get();
    }
}
