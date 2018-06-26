<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FlowMeter extends Model
{
    protected $fillable = [
        'date', 'fuel_tank_id', 'sounding', 'volume_by_sounding', 'flowmeter',
        'user_id', 'status', 'transfer_to_fuel_tank_id', 'sadp_id', 'shift'
    ];

    public function fuelTank() {
        return $this->belongsTo(FuelTank::class);
    }
}
