<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WarningPart extends Model
{
    protected $fillable = ['breakdown_id', 'status', 'note', 'user_id'];
}
