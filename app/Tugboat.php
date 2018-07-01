<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tugboat extends Model
{
    protected $fillable = ['name', 'description', 'status', 'jetty_id'];
}
