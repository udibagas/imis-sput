<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DwellingTime extends Model
{
    protected $fillable = [
        'time', 'status', 'volume', 'jetty_id',
        'barging_id', 'description', 'user_id'
    ];
}
