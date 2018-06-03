<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AssetTaking extends Model
{
    protected $fillable = [
        'date', 'asset_id', 'asset_location_id',
        'asset_status_id', 'user_id', 'note'
    ];

    public function asset() {
        return $this->belongsTo(Asset::class);
    }
}
