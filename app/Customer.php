<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'name', 'address', 'email', 'phone', 'fax',
        'default_seam_id', 'default_material_type'
    ];
}
