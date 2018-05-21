<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Prajob extends Model
{
    protected $fillable = [
        'employee_id', 'tgl', 'shift', 'jam_tidur', 'jam_tidur_kemarin',
        'jam_bangun', 'jam_bangun_kemarin', 'minum_obat', 'ada_masalah',
        'siap_bekerja', 'approval_status', 'approval_date', 'supervising_prediction_id',
        'stop_working_prediction_id', 'approval_by', 'recomended_by', 'terminal_id',
        'spo', 'bpm'
    ];

    public function getJamTidurAttribute($v) {
        return date('H:i', strtotime($v));
    }

    public function getJamBangunAttribute($v) {
        return date('H:i', strtotime($v));
    }

}
