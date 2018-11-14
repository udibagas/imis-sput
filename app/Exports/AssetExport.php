<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Asset;

class AssetExport implements FromQuery, WithHeadings
{
    public $request = false;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function headings(): array
    {
        return [
            'Registration Number',
            'Name',
            'Trademark',
            'Version',
            'SN',
            'Lifetime',
            'Price',
            'Value',
            'Year',
            'Uselife',
            'Type',
            'Category',
            'Vendor',
            'Location',
            'Status'
        ];
    }

    public function query()
    {
        $request = $this->request;

        return Asset::selectRaw('
                assets.reg_no AS reg_no,
                assets.name AS name,
                assets.trademark AS trademark,
                assets.version AS version,
                assets.sn AS sn,
                assets.lifetime AS lifetime,
                assets.price AS price,
                assets.value AS value,
                assets.year AS year,
                assets.uselife AS uselife,
                IF(assets.type = 1, "OWN", "RENT"),
                asset_categories.name AS category,
                asset_vendors.name AS vendor,
                asset_locations.name AS location,
                asset_statuses.code AS status
            ')
            ->join('asset_locations', 'asset_locations.id', '=', 'assets.asset_location_id')
            ->join('asset_statuses', 'asset_statuses.id', '=', 'assets.asset_status_id')
            ->join('asset_categories', 'asset_categories.id', '=', 'assets.asset_category_id', 'LEFT')
            ->join('asset_vendors', 'asset_vendors.id', '=', 'assets.asset_vendor_id', 'LEFT')
            ->orderBy('reg_no', 'DESC');
    }
}
