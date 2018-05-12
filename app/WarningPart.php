<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WarningPart extends Model
{
    protected $fillable = ['breakdown_id', 'status', 'note', 'user_id'];

    public function breakdown() {
        return $this->belongsTo(Breakdown::class);
    }
}
