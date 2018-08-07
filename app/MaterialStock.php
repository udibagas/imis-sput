<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MaterialStock extends Model
{
    protected $fillable = [
        'dumping_date', 'stock_area_id', 'material_type',
        'seam_id', 'customer_id', 'volume'
    ];

    protected $appends = ['age'];

    public function getAgeAttribute()
    {
        $in = date_create($this->dumping_date);
        $out = date_create(date("Y-m-d"));
        return date_diff($in, $out)->format('%d hari');
    }

    public static function getList()
    {
        return self::selectRaw('
            material_stocks.id AS id, CONCAT(customers.name, "/", areas.name, "/", stock_areas.name, "/", IF(material_type = "l", "LOW", "HIGH"), "/", seams.name) AS text
        ')
        ->join('stock_areas', 'stock_areas.id', '=', 'material_stocks.stock_area_id')
        ->join('areas', 'areas.id', '=', 'stock_areas.area_id')
        ->join('customers', 'customers.id', '=', 'material_stocks.customer_id')
        ->join('seams', 'seams.id', '=', 'material_stocks.seam_id', 'LEFT')
        ->get();
    }

}
