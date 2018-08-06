<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Barging extends Model
{
    protected $fillable = [
        'start', 'stop', 'jetty_id', 'barge_id',
        'buyer_id', 'volume', 'progress', 'status', 'description',
        'customer_id', 'tugboat_id'
    ];

    protected $with = ['bargingMaterial'];

    public function bargingMaterial() {
        return $this->hasMany(BargingMaterial::class);
    }

    public function dwellingTime() {
        return $this->hasMany(DwellingTime::class);
    }
}
