<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PortActivity extends Model
{
    protected $fillable = [
        'date', 'time_start', 'time_end',
        'employee_id', 'unit_id', 'unit_activity_id',
        'stock_area_id', 'material_type', 'seam_id',
        'customer_id', 'volume', 'rit'
    ];
}
