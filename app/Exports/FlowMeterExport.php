<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\FlowMeter;

class FlowMeterExport implements FromQuery, WithHeadings
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
            'Shift',
            'Fuel Tank/SADP',
            'Status',
            'To',
            'Flowmeter',
            'Sounding',
            'Volume By Sounding',
            'Selisih Volume'
        ];
    }


    public function query()
    {
        $request = $this->request;

        return FlowMeter::selectRaw('
                flow_meters.date AS date,
                flow_meters.shift AS shift,
                CASE
                    WHEN flow_meters.fuel_tank_id > 0 THEN fuel_tanks.name
                    WHEN flow_meters.sadp_id > 0 THEN sadps.name
                END,
                IF(flow_meters.status = "S", "Stock Awal", "Transfer"),
                t.name AS transfer_to,
                flow_meters.flowmeter AS flowmeter,
                flow_meters.sounding AS sounding,
                flow_meters.volume_by_sounding AS volume_by_sounding,
                flow_meters.volume_by_sounding - flow_meters.flowmeter AS selisih
            ')
            ->join('fuel_tanks', 'fuel_tanks.id', '=', 'flow_meters.fuel_tank_id', 'LEFT')
            ->join('fuel_tanks AS t', 't.id', '=', 'flow_meters.transfer_to_fuel_tank_id', 'LEFT')
            ->join('sadps', 'sadps.id', '=', 'flow_meters.sadp_id', 'LEFT')
            ->join('users', 'users.id', '=', 'flow_meters.user_id', 'LEFT')
            ->when($request, function($query) use ($request) {
                return $query->whereRaw("`date` BETWEEN '{$request->from}' AND '{$request->to}'");
            })
            ->orderBy('date', 'DESC');
    }
}
