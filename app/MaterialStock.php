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

}
