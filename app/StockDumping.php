<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StockDumping extends Model
{
    protected $fillable = [
        'subcont_unit_id', 'stock_area_id',
        'volume', 'user_id', 'insert_via', 'date', 'time',
        'material_type', 'seam_id', 'customer_id', 'shift', 'register_number'
    ];

    protected $with = ['stockArea', 'subcontUnit'];

    public function stockArea() {
        return $this->belongsTo(StockArea::class);
    }

    public function subcontUnit() {
        return $this->belongsTo(SubcontUnit::class);
    }

    public function customer() {
        return $this->belongsTo(Customer::class);
    }

    public function getTimeAttribute($value) {
        return substr($value, 0, 5);
    }
}
