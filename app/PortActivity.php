<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PortActivity extends Model
{
    public $activities = [];

    public function __construct()
    {
        parent::__construct();
        $activities = UnitActivity::all();

        foreach ($activities as $a) {
            $this->activities[$a->id] = strtolower($a->name);
        }
    }

    protected $fillable = [
        'date', 'time_start', 'time_end', 'hauler_id',
        'employee_id', 'unit_id', 'unit_activity_id',
        'stock_area_id', 'material_type', 'seam_id',
        'customer_id', 'volume', 'rit', 'shift', 'hopper_id'
    ];
}
