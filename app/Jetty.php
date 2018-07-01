<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Jetty extends Model
{
    protected $fillable = ['name', 'description', 'capacity', 'order', 'status'];

    protected $with = ['stockArea', 'barge', 'tugboat',  'units'];

    public function stockArea() {
        return $this->hasMany(StockArea::class);
    }

    public function barge() {
        return $this->hasOne(Barge::class);
    }

    public function tugboat() {
        return $this->hasOne(Tugboat::class);
    }

    public function units() {
        return $this->hasMany(Unit::class);
    }
}
