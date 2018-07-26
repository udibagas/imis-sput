<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subcont extends Model
{
    protected $fillable = ['name', 'description'];

    public function subcontUnits()
    {
        return $this->hasMany(SubcontUnit::class);
    }
}
