<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BaseSurface extends Model
{
    protected $connection = 'sqlsrv';

    protected $table = 'BaseSurface';
}
