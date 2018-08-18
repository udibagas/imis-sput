<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Egi extends Model
{
    protected $fillable = [
        'name', 'description', 'status', 'fc', 'is_utama',
        'mt_per_bucket_lo', 'mt_per_bucket_hi'
    ];
}
