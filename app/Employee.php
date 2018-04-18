<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = [
        'nrp', 'name', 'department_id',
        'position_id', 'owner_id', 'office_id', 'status'
    ];
}
