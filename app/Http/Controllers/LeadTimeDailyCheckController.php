<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use App\Pitstop;

class LeadTimeDailyCheckController extends Controller
{
    public function index(Request $request)
    {
        if (Gate::denies('view-leadtime-daily-check')) {
            abort(403, 'Unauthorized action.');
        }

        if ($request->ajax())
        {
            return Pitstop::selectRaw('
                    pitstops.*,
                    units.name AS unit,
                    locations.name AS location
                ')
                ->join('units', 'units.id', '=', 'pitstops.unit_id')
                ->join('locations', 'locations.id', '=', 'pitstops.location_id')
                ->where('pitstops.status', 0)
                ->orderBy('created_at', 'DESC')->get();
        }

        return view('pitstop.leadTimeDailyCheck', [
            'breadcrumbs' => [
                'plant/dashboard' => 'Plant',
                '#' => 'Lead Time Daily Check'
            ]
        ]);
    }
}
