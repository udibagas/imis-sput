<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    protected $fillable = [
        'name', 'egi_id', 'owner_id', 'alocation_id', 'status'
    ];
}
