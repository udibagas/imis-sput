<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubArea extends Model
{
    protected $fillable = ['name', 'capacity', 'description', 'area_id'];
}
