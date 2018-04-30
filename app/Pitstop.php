<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pitstop extends Model
{
    protected $fillable = [
        'unit_id', 'user_id', 'location_id', 'time_in', 'time_out',
        'shift', 'description', 'hm', 'status'
    ];

    public function isDuplicate($unit_id, $time_in)
    {
        return self::where('unit_id', '=', $unit_id)
            -where('time_in', '=', $time_in)
            ->count();
    }
}
