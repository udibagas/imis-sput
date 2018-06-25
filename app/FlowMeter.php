<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FlowMeter extends Model
{
    protected $fillable = [
        'date', 'fuel_tank_id', 'flowmeter_start', 'flowmeter_end',
        'sounding_start', 'sounding_end', 'volume_by_sounding',
        'user_id', 'status', 'transfer_to_fuel_tank_id', 'sadp_id',
        'shift'
    ];

    public function fuelTank() {
        return $this->belongsTo(FuelTank::class);
    }

    public function getFlowmeterStartAttribute($value)
    {
        return (int) ($value);
    }

    public function getFlowmeterEndAttribute($value)
    {
        return (int) $value;
    }

    public function getSoundingStartAttribute($value)
    {
        return (int) $value;
    }

    public function getSoundingEndAttribute($value)
    {
        return (int) $value;
    }

    public function getVolumeBySoundingAttribute($value)
    {
        return (int) $value;
    }
}
