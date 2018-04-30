<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Egi extends Model
{
    protected $fillable = ['name', 'description', 'status', 'fc'];
}
