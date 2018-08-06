<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Jetty extends Model
{
    protected $fillable = ['name', 'description', 'capacity', 'order', 'status'];

    protected $with = ['hoppers'];

    public function barge() {
        return $this->hasOne(Barge::class);
    }

    public function tugboat() {
        return $this->hasOne(Tugboat::class);
    }

    public function units() {
        return $this->hasMany(Unit::class);
    }

    public function hoppers() {
        return $this->hasMany(Hopper::class);
    }
}
