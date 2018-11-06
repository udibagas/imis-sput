<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use QRCode;

class Unit extends Model
{
    protected $fillable = [
        'name', 'egi_id', 'owner_id', 'status',
        'unit_category_id', 'type', 'last_hm', 'last_km'
    ];

    public function egi() {
        return $this->belongsTo(Egi::class);
    }

    public function getQrCodeAttribute()
    {
        return QRCode::text($this->name)
            ->setMargin(2)
            ->setSize(7)
            ->svg();
    }
}
