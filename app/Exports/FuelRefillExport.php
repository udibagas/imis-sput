<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\FuelRefill;

class FuelRefillExport implements FromQuery, WithHeadings
{
    public $request = false;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function headings(): array
    {
        return [
            'Date',
            'Trx',
            'Status',
            'Fuel Tank',
            'Flowmeter Start',
            'Flowmeter End',
            'Sounding Start',
            'Sounding End',
            'Volume By Flowmeter',
            'Volume By Sounding',
            'Selisih Volume'
        ];
    }


    public function query()
    {
        $request = $this->request;

        return FuelRefill::selectRaw('
                flow_meters.date AS date,
                IF (flow_meters.flowmeter_start - flow_meters.flowmeter_end > 0 , "IN", "OUT") as trx,
                flow_meters.status AS status,
                fuel_tanks.name AS fuel_tank,
                flow_meters.flowmeter_start AS flowmeter_start,
                flow_meters.flowmeter_end AS flowmeter_end,
                flow_meters.sounding_start AS sounding_start,
                flow_meters.sounding_end AS sounding_end,
                (flow_meters.flowmeter_end - flow_meters.flowmeter_start) AS volume_by_flowmeter,
                flow_meters.volume_by_sounding AS volume_by_sounding,
                flow_meters.volume_by_sounding - (flow_meters.flowmeter_end - flowmeter_start) AS selisih
            ')
            ->join('fuel_tanks', 'fuel_tanks.id', '=', 'flow_meters.fuel_tank_id')
            ->when($request, function($query) use ($request) {
                return $query->whereRaw("`date` BETWEEN '{$request->from}' AND '{$request->to}'");
            })
            ->orderBy('date', 'DESC');
    }
}
