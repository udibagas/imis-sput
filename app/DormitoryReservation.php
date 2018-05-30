<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class DormitoryReservation extends Model
{
    protected $fillable = [
        'permit_number', 'employee_id', 'dormitory_room_id',
        'check_in', 'check_out', 'need', 'is_checked_out'
    ];

    protected $appends = ['status', 'cuti'];

    public function getStatusAttribute()
    {
        // merah
        if ($this->cuti >= 0 && !$this->is_checked_out) {
            return 0;
        }

        // kuning
        if ($this->cuti > -4 && !$this->is_checked_out) {
            return 1;
        }

        // hijau
        if ($this->is_checked_out) {
            return 2;
        }

        // default
        return 3;
    }

    public function getCutiAttribute()
    {
        $out = date_create($this->check_out);
        return date_diff($out, now())->format('%R%d');
    }

    public function scopeCurrent($query)
    {
        return $query->whereRaw("(DATE(NOW()) BETWEEN check_in AND check_out OR is_checked_out = 0)");
    }
}
