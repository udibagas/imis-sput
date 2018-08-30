<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DraughtSurvey extends Model
{
    protected $fillable = [
        'barging_id', 'barging_material_id', 'user_id',
        'volume', 'pic'
    ];
}
