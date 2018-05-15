<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pitstop extends Model
{
    protected $fillable = [
        'unit_id', 'user_id', 'location_id', 'time_in', 'time_out',
        'shift', 'description', 'hm', 'status'
    ];

    protected $appends = ['duration'];

    public function isDuplicate($unit_id, $time_in)
    {
        return self::where('unit_id', '=', $unit_id)
            -where('time_in', '=', $time_in)
            ->count();
    }

    public function getDurationAttribute()
    {
        $in = new \DateTime($this->time_in);
        $out = new \DateTime($this->time_out);
        $interval = $in->diff($out);
        return $interval->format('%H:%i');
    }
}
