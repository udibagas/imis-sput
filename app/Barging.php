<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Barging extends Model
{
    public const STATUS_START = 0;
    public const STATUS_LOADING = 1;
    public const STATUS_BREAKOWN = 2;
    public const STATUS_DELAY = 3;
    public const STATUS_IDLE = 4;
    public const STATUS_COMPLETE = 5;

    protected $fillable = [
        'start', 'stop', 'jetty_id', 'barge_id',
        'buyer_id', 'volume', 'progress', 'status', 'description',
        'customer_id', 'tugboat_id', 'volume_by_bucket_ctrl'
    ];

    protected $with = ['bargingMaterial'];

    public function bargingMaterial() {
        return $this->hasMany(BargingMaterial::class);
    }

    public function dwellingTime() {
        return $this->hasMany(DwellingTime::class);
    }

    public static function getStatusList()
    {
        return [
            ['id' => self::STATUS_START, 'text' => 'Initiate', 'color' => 'info'],
            ['id' => self::STATUS_LOADING, 'text' => 'Loading', 'color' => 'success'],
            ['id' => self::STATUS_BREAKOWN, 'text' => 'Breakdown', 'color' => 'danger'],
            ['id' => self::STATUS_DELAY, 'text' => 'Delay', 'color' => 'warning'],
            ['id' => self::STATUS_IDLE, 'text' => 'Idle', 'color' => 'default'],
            ['id' => self::STATUS_COMPLETE, 'text' => 'Complete', 'color' => 'primary'],
        ];
    }
}
