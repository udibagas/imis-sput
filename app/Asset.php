<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use QRCode;

class Asset extends Model
{
    protected $fillable = [
        'reg_no', 'name', 'trademark', 'version', 'sn',
        'lifetime', 'price', 'year', 'asset_location_id',
        'asset_status_id'
    ];

    public function getQrCodeAttribute()
    {
        return QRCode::text($this->reg_no)
            ->setMargin(2)
            ->setSize(5)
            ->svg();
    }
}
