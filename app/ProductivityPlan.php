<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductivityPlan extends Model
{
    protected $fillable = ['egi_id', 'unit_activity_id', 'hi_cv', 'lo_cv'];
}
