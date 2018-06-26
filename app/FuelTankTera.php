<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FuelTankTera extends Model
{
    protected $fillable = ['fuel_tank_id', 'depth', 'volume'];
}
