<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pitstop extends Model
{
    protected $fillable = [
        'unit_id', 'user_id', 'station_id', 'time_in', 'time_out',
        'shift', 'description', 'hm', 'status'
    ];
}
