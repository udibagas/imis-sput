<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FuelRefill extends Model
{
    protected $fillable = [
        'fuel_tank_id', 'unit_id', 'date', 'employee_id',
        'km', 'hm', 'km_last', 'hm_last', 'total_recommended',
        'total_real', 'user_id', 'shift', 'start_time', 'finish_time'
    ];
}
