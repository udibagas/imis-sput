<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use QRCode;

class Employee extends Model
{
    protected $fillable = [
        'nrp', 'name', 'department_id',
        'position_id', 'owner_id', 'office_id', 'status'
    ];

    public function position() {
        return $this->belongsTo(Position::class);
    }

    public function department() {
        return $this->belongsTo(Department::class);
    }

    public function getQrCodeAttribute()
    {
        return QRCode::text($this->nrp)
            ->setMargin(2)
            ->setSize(5)
            ->svg();
    }
}
