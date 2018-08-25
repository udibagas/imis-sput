<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Jetty extends Model
{
    protected $fillable = ['name', 'description', 'capacity', 'order', 'status'];

    protected $with = ['hoppers', 'stockArea'];

    protected $appends = ['stockAreaMap'];

    public function units() {
        return $this->hasMany(Unit::class);
    }

    public function hoppers() {
        return $this->hasMany(Hopper::class);
    }

    public function stockArea() {
        return $this->hasMany(StockArea::class);
    }

    public function getStockAreaMapAttribute()
    {
        $sql = "SELECT
            `order`,
            GROUP_CONCAT(name) AS name,
            GROUP_CONCAT(capacity) AS capacity,
            GROUP_CONCAT(position) AS position
        FROM stock_areas
        WHERE jetty_id = ?
        GROUP BY `order`
        ORDER BY `order`";

        $ret = [];
        $data = DB::select($sql, [$this->id]);

        foreach ($data as $i => $d)
        {
            $ret[$i] = [];

            foreach (explode(",", $d->name) as $ii => $name)
            {
                $ret[$i][$ii] = [
                    'name' => explode(",", $d->name)[$ii],
                    'position' => explode(",", $d->position)[$ii],
                    'capacity' => explode(",", $d->capacity)[$ii],
                ];
            }
        }

        return $ret;
    }

}
