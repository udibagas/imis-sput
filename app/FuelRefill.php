<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class FuelRefill extends Model
{
    protected $fillable = [
        'fuel_tank_id', 'unit_id', 'date', 'employee_id',
        'km', 'hm', 'km_last', 'hm_last', 'total_recommended',
        'total_real', 'user_id', 'shift', 'start_time', 'finish_time', 'insert_via'
    ];

    public function fuelTank() {
        return $this->belongsTo(FuelTank::class);
    }

    public function getStartTimeAttribute($value) {
        return date('H:i', strtotime($value));
    }

    public function getFinishTimeAttribute($value) {
        return date('H:i', strtotime($value));
    }

    public static function getFc($start, $end)
    {
        $sql = "SELECT
                e.name AS egi,
                AVG(e.fc) AS fc_standard,
                SUM(COALESCE(f.hm, 0) - COALESCE(f.hm_last, 0)) / SUM(COALESCE(f.total_real, 0)) AS fc
            FROM fuel_refills f
            JOIN units u ON u.id = f.unit_id
            JOIN egis e ON e.id = u.egi_id
            WHERE f.date BETWEEN '$start' AND '$end'
            GROUP BY e.name
            ORDER BY e.name ASC";

        return DB::select(DB::raw($sql));
    }

}
