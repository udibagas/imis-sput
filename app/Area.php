<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    protected $fillable = ['name', 'capacity', 'description'];

    protected $with = ['subArea'];

    public function subArea() {
        return $this->hasMany(SubArea::class);
    }
}
