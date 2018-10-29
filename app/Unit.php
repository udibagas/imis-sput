<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    protected $fillable = [
        'name', 'egi_id', 'owner_id', 'status',
        'unit_category_id', 'type', 'last_hm', 'last_km'
    ];

    public function egi() {
        return $this->belongsTo(Egi::class);
    }
}
