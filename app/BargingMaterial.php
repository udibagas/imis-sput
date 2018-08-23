<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BargingMaterial extends Model
{
    protected $fillable = [
        'barging_id', 'contractor_id', 'material_type',
        'seam_id', 'volume', 'volume_progress', 'volume_by_draught_survey'
    ];

    public function setVolumeAttribute($v) {
        $this->attributes['volume'] = $v * 1000;
    }

    public function getVolumeAttribute($v) {
        return $v / 1000;
    }

    public function setVolumeProgressAttribute($v) {
        $this->attributes['volume_progress'] = $v * 1000;
    }

    public function getVolumeProgressAttribute($v) {
        return $v / 1000;
    }

    public function setVolumeByDraughtSurveyAttribute($v) {
        $this->attributes['volume_by_draught_survey'] = $v * 1000;
    }

    public function getVolumeByDraughtSurveyAttribute($v) {
        return $v / 1000;
    }
}
