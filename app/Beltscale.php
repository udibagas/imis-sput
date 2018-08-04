<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Beltscale extends Model
{
    protected $connection = 'beltscale';

    protected $table = 'ClientTrans';

    // 244	: JETTY-H
    // 245	: JETTY-J
    // 246	: JETTY-U
    // 247	: JETTY-K


}
