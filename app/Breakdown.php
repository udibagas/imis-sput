<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Breakdown extends Model
{
    protected $fillable = [
        'unit_id', 'location_id', 'breakdown_category_id',
        'km', 'hm', 'time_in', 'time_out', 'time_ready',
        'diagnosa', 'tindakan', 'description', 'warning_part',
        'wo_number', 'breakdown_status_id', 'component_criteria_id',
        'update_pcr_time', 'update_pcr_by', 'status', 'user_id'
    ];

    protected $appends = ['duration', 'downtime', 'ready_time'];

    public function getDurationAttribute()
    {
        if ($this->time_out) {
            $in = date_create($this->time_in);
            $out = date_create($this->time_out);
            return date_diff($in, $out)->format('%d hari %h jam %i menit');
        }

        return '';
    }

    public function getReadyTimeAttribute()
    {
        if ($this->time_out) {
            return Carbon::parse($this->time_out)->diffForHumans();
        }

        return '';
    }

    public function getDowntimeAttribute()
    {
        $in = date_create($this->time_in);
        $now = date_create();
        return date_diff($in, $now)->format('%d hari %h jam %i menit');
    }

    public function unit() {
        return $this->belongsTo(Unit::class);
    }

    public function warningPart() {
        return $this->hasOne(WarningPart::class);
    }

}
