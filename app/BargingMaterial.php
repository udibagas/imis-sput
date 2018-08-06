<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BargingMaterial extends Model
{
    protected $fillable = ['barging_id', 'customer_id', 'material_type', 'seam_id', 'volume'];
}
