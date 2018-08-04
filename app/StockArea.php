<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StockArea extends Model
{
    protected $fillable = [
        'area_id', 'name', 'capacity', 'stock', 'age', 'position', 'order'
    ];

    public function jetty() {
        return $this->belongsTo(Jetty::class);
    }
}
