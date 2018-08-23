<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    protected $fillable = ['name', 'capacity', 'description', 'jetty_id'];

    protected $with = ['stockArea'];

    public function stockArea() {
        return $this->hasMany(StockArea::class);
    }

    // public function jetty() {
    //     return $this->belongsTo(Jetty::class);
    // }
}
