<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Authorization extends Model
{
    protected $fillable = [
        'controller', 'create', 'update', 'delete', 'export', 'import',
        'dashboard'
    ];

    public static function getModule()
    {
        return [
            'Alocation' => ['create', 'update', 'delete']
        ];
    }
}
