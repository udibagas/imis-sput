<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Meal extends Model
{
    protected $fillable = ['date', 'employee_id', 'meal_location_id', 'type', 'status'];
}
