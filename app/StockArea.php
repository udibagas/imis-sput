<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class StockArea extends Model
{
    protected $fillable = [
        'area_id', 'name', 'capacity', 'position', 'order', 'jetty_id'
    ];

    protected $appends = ['stock'];

    public function area() {
        return $this->belongsTo(Area::class);
    }

    public function jetty() {
        return $this->belongsTo(Jetty::class);
    }

    public function getStockAttribute()
    {
        $sql = "SELECT (SUM(volume) / 1000) AS volume FROM material_stocks WHERE stock_area_id = ?";
        return DB::select($sql, [$this->id])[0]->volume;
    }

    public function setCapacityAttribute($v) {
        $this->attributes['capacity'] = $v * 1000;
    }

    public function getCapacityAttribute($v) {
        return $v / 1000;
    }
}
