<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Seam extends Model
{
    protected $fillable = ['name', 'description', 'color'];

    protected $visible = ['id', 'name', 'description', 'color'];
}
