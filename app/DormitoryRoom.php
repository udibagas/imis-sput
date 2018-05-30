<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DormitoryRoom extends Model
{
    protected $fillable = [
        'name', 'dormitory_id', 'capacity', 'status', 'pic'
    ];

    protected $appends = ['kosong', 'terisi'];

    public function getTerisiAttribute()
    {
        return DormitoryReservation::selectRaw('COUNT(id) AS terisi')
            ->where('dormitory_room_id', $this->id)
            ->whereRaw("((DATE(NOW()) BETWEEN check_in AND check_out AND is_checked_out = 0) OR is_checked_out = 0)")
            ->first()->terisi;
    }

    public function getKosongAttribute()
    {
        return $this->capacity - $this->terisi;
    }

    public function reservations() {
        return $this->hasMany(DormitoryReservation::class);
    }

    public function dormitory() {
        return $this->belongsTo(Dormitory::class);
    }

    public static function getSelect() {
        return self::selectRaw('dormitory_rooms.id AS id, CONCAT(dormitories.name, " (", dormitory_rooms.name, ")") AS text')
            ->orderBy('dormitories.name', 'ASC')
            ->orderBy('dormitory_rooms.name', 'ASC')
            ->join('dormitories', 'dormitories.id', '=', 'dormitory_rooms.dormitory_id')
            ->get();
    }
}
