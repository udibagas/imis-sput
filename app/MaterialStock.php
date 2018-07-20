<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MaterialStock extends Model
{
    protected $fillable = [
        'dumping_date', 'stock_area_id', 'material_type',
        'seam_id', 'customer_id', 'volume'
    ];

}
