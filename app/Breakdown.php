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
        $in = Carbon::parse($this->time_in);
        $out = Carbon::parse($this->time_out);
        return $in->diffForHumans($out, true);
    }

    public function getReadyTimeAttribute()
    {
        return Carbon::parse($this->time_out)->diffForHumans();
    }

    public function getDowntimeAttribute()
    {
        $in = Carbon::parse($this->time_in);
        $downtime = Carbon::now()->diffInSeconds($in);
        $jam = ($downtime-($downtime%3600))/3600;
        $menit = (($downtime%3600) - ($downtime%60))/60;
        $detik = $downtime%60;
        return sprintf('%02d', $jam).":".sprintf('%02d', $menit).":".sprintf('%02d', $detik);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

}
