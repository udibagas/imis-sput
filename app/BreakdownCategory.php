<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BreakdownCategory extends Model
{
    protected $fillable = ['name', 'description_id', 'description_en', 'status'];
}
