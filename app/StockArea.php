<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StockArea extends Model
{
    protected $fillable = [
        'jetty_id', 'name', 'capacity', 'stock', 'age', 'position', 'order'
    ];
}
