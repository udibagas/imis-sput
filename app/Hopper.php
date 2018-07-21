<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hopper extends Model
{
    protected $fillable = ['jetty_id', 'name', 'description'];
}
