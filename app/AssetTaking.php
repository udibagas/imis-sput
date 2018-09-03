<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AssetTaking extends Model
{
    protected $fillable = [
        'date', 'asset_id', 'old_asset_location_id',
        'old_asset_status_id', 'user_id', 'note',
        'new_asset_status_id', 'new_asset_location_id'
    ];

    public function asset() {
        return $this->belongsTo(Asset::class);
    }
}
