<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BaseSurface extends Model
{
    protected $connection = 'water_surface';

    protected $table = 'BaseSurface';
}
