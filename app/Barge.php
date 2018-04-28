<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Barge extends Model
{
    protected $fillable = ['name', 'description', 'anchored'];

    public function getUpdatedAtAttribute($value)
    {
        $time = Carbon::parse($value);
        return $time->diffForHumans();
    }
}
