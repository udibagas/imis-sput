<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubcontUnit extends Model
{
    protected $fillable = [
        'code_number', 'type', 'model', 'subcont_id',
        'empty_weight', 'average_weight'
    ];
}
