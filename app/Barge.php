<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Barge extends Model
{
    protected $fillable = ['name', 'description', 'anchored'];

    public function getUpdatedAtAttribute($value)
    {
        return $value;
        // return $value->diffForHumans();
    }
}
