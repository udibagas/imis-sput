<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LostTimeCategory extends Model
{
    protected $fillable = ['code', 'description', 'status'];
}
