<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    protected $fillable = ['name', 'capacity', 'description', 'group'];

    protected $with = ['stockArea'];

    public function stockArea() {
        return $this->hasMany(StockArea::class);
    }

    public function setCapacityAttribute($v) {
        $this->attributes['capacity'] = $v * 1000;
    }

    public function getCapacityAttribute($v) {
        return $v / 1000;
    }
}
