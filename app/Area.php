<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    protected $fillable = ['name', 'capacity', 'description'];

    protected $with = ['stockArea'];

    public function stockArea() {
        return $this->hasMany(StockArea::class);
    }
}
