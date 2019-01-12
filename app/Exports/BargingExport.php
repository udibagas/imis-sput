<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\BargingMaterial;

class BargingExport implements FromQuery, WithHeadings
{
    public $request = false;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function headings(): array
    {
        return [
            'Draft',
            'Tugboat',
            'Barge',
            'TA',
            'Time',
            'TD',
            'Time',
            'Shipper Name',
            'Sub Source',
            'Sub Total (MT)',
            'Total Cargo',
            'Persentase',
            'Jetty',
            'Tujuan'
        ];
    }


    public function query()
    {
        $request = $this->request;
        return BargingMaterial::selectRaw('
                barging_materials.draft,
                tugboats.name AS tugboat,
                barges.name AS barge,
                DATE(bargings.start) AS ta,
                TIME(bargings.start) AS ta_time,
                DATE(bargings.stop) AS td,
                TIME(bargings.stop) AS td_time,
                customers.name AS customer,
                seams.name AS seam,
                barging_materials.volume_by_draught_survey,
                barging_materials.volume,
                CONCAT(ROUND((barging_materials.volume_progress / barging_materials.volume * 100), 2), "%"),
                jetties.name AS jetty,
                buyers.name AS buyer
            ')
            ->join('bargings', 'bargings.id', '=', 'barging_materials.barging_id')
            ->join('contractors', 'contractors.id', '=', 'barging_materials.contractor_id')
            ->join('seams', 'seams.id', '=', 'barging_materials.seam_id', 'LEFT')
            ->join('jetties', 'jetties.id', '=', 'bargings.jetty_id')
            ->join('barges', 'barges.id', '=', 'bargings.barge_id')
            ->join('buyers', 'buyers.id', '=', 'bargings.buyer_id')
            ->join('tugboats', 'tugboats.id', '=', 'bargings.tugboat_id')
            ->join('customers', 'customers.id', '=', 'bargings.customer_id')
            ->when($request, function($q) use ($request) {
                return $q->whereRaw("DATE(`start`) BETWEEN '{$request->from}' AND '{$request->to}'");
            })->orderBy('bargings.start', 'ASC');
    }
}
