<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cargo extends Model
{
    protected $fillable = [
        'name', 'address', 'email', 'phone', 'fax'
    ];
}
