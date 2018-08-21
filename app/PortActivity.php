<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PortActivity extends Model
{
    public $activities = [];

    public const ACT_HAULING = 1;
    public const ACT_FEEDING = 2;
    public const ACT_LOAD_AND_CARRY = 3;
    public const ACT_LOADING = 4;
    public const ACT_STOCKPILING = 5;
    public const ACT_BREAKDOWN = 6;
    public const ACT_STANDBY = 7;

    protected $with = ['hopper'];

    protected $fillable = [
        'date', 'time_start', 'time_end', 'hauler_id',
        'employee_id', 'unit_id', 'unit_activity_id',
        'volume', 'rit', 'shift', 'hopper_id', 'seam_id',
        'material_stock_id', 'user_id', 'material_type',
        'customer_id'
    ];

    public function getTimeStartAttribute($v) {
        return substr($v, 0, 5);
    }

    public function getTimeEndAttribute($v) {
        return substr($v, 0, 5);
    }

    public function setVolumeAttribute($v) {
        $this->attributes['volume'] = $v * 1000;
    }

    public function getVolumeAttribute($v) {
        return $v / 1000;
    }

    public function getJettyIdAttribute()
    {
        return ($this->hopper) ? $this->hopper->jetty_id : 0;
    }

    public function hopper() {
        return $this->belongsTo(Hopper::class);
    }

    public static function getActivityList($act = false)
    {
        $activities = [
            ['id' => self::ACT_HAULING, 'text' => 'Hauling'],
            ['id' => self::ACT_FEEDING, 'text' => 'Feeding'],
            ['id' => self::ACT_LOAD_AND_CARRY, 'text' => 'Load and Carry'],
            ['id' => self::ACT_LOADING, 'text' => 'Loading'],
            ['id' => self::ACT_STOCKPILING, 'text' => 'Stock Piling'],
            ['id' => self::ACT_BREAKDOWN, 'text' => 'Breakdown'],
            ['id' => self::ACT_STANDBY, 'text' => 'Standby']
        ];

        return $act ? $activities[$act] : $activities;
    }

    public function materialStock() {
        return $this->belongsTo(MaterialStock::class);
    }
}
