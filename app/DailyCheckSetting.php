<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DailyCheckSetting extends Model
{
    protected $fillable = ['day', 'unit_id', 'user_id'];
}
