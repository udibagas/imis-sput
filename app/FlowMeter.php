<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FlowMeter extends Model
{
    protected $fillable = [
        'date', 'fuel_tank_id', 'flowmeter_start', 'flowmeter_end',
        'sounding_start', 'sounding_end', 'volume_by_sounding',
        'user_id', 'status'
    ];
}
