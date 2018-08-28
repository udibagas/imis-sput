<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MaterialStock extends Model
{
    protected $fillable = [
        'dumping_date', 'stock_area_id', 'material_type',
        'seam_id', 'customer_id', 'volume', 'contractor_id'
    ];

    protected $appends = ['age'];

    public function getAgeAttribute()
    {
        $in = date_create($this->dumping_date);
        $out = date_create(date("Y-m-d"));
        return date_diff($in, $out)->format('%d hari');
    }

    public function setVolumeAttribute($v) {
        $this->attributes['volume'] = $v * 1000;
    }

    public function getVolumeAttribute($v) {
        return $v / 1000;
    }

    public static function getList()
    {
        return self::selectRaw('
            material_stocks.id AS id, CONCAT(customers.name, "/", contractors.name, "/", areas.name, "/", stock_areas.name, "/", IF(material_type = "l", "LOW", "HIGH"), "/", seams.name) AS text,
            material_stocks.material_type AS material_type,
            material_stocks.seam_id AS seam_id,
            contractor_id,
            customer_id
        ')
        ->join('stock_areas', 'stock_areas.id', '=', 'material_stocks.stock_area_id')
        ->join('areas', 'areas.id', '=', 'stock_areas.area_id')
        ->join('customers', 'customers.id', '=', 'material_stocks.customer_id')
        ->join('contractors', 'contractors.id', '=', 'material_stocks.contractor_id')
        ->join('seams', 'seams.id', '=', 'material_stocks.seam_id', 'LEFT')
        ->get();
    }

}
