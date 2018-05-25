<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dormitory extends Model
{
    protected $fillable = ['name', 'description', 'total_room', 'status'];
}
