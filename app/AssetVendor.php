<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AssetVendor extends Model
{
    protected $fillable = ['name', 'address', 'phone'];
}
