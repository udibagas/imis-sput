<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    protected $fillable = ['employee_id', 'in', 'out'];

    public function getDateAttribute()
    {
        return date('Y-m-d', strtotime($this->in));
    }

    public function getShiftAttribute()
    {
        $hour = date('G', strtotime($this->in));
        return ($hour >= 7 && $hour < 19) ? 1 : 2;
    }
}
