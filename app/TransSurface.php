<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransSurface extends Model
{
    protected $connection = 'water_surface';

    protected $table = 'TransSurface';
}
