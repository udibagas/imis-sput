<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransSurface extends Model
{
    protected $connection = 'sqlsrv';

    protected $table = 'TransSurface';
}
