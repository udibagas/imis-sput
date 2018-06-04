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

    public function getLocationAttribute() {
        return $this->assetLocation->name;
    }

    public function getStatusAttribute() {
        return $this->assetStatus->code;
    }

    public function getPriceAttribute($value) {
        return (int) $value;
    }

    public function getQrCodeAttribute()
    {
        return QRCode::text($this->reg_no)
            ->setMargin(2)
            ->setSize(4)
            ->svg();
    }

    public function assetLocation() {
        return $this->belongsTo(AssetLocation::class);
    }

    public function assetStatus() {
        return $this->belongsTo(AssetStatus::class);
    }
}
