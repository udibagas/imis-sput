<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TerminalAbsensi extends Model
{
    protected $fillable = [
        'code', 'ip_address', 'location_id'
    ];
}
