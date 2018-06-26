<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FuelTank extends Model
{
    protected $fillable = [
        'name', 'description', 'capacity', 'stock',
        'last_stock_time', 'last_position_time',
        'latitude', 'longitude', 'altitude',
        'heading', 'speed', 'accuracy'
    ];

    public function tera() {
        return $this->hasMany(FuelTankTera::class);
    }
}
