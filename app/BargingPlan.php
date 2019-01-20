<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BargingPlan extends Model
{
    protected $fillable = ['date', 'customer_id', 'volume'];

    public static function getPeriod($year)
    {
        return [
            [$year.'-01-01', $year.'-01-25'],
            [$year.'-01-26', $year.'-02-25'],
            [$year.'-02-26', $year.'-03-25'],
            [$year.'-03-26', $year.'-04-25'],
            [$year.'-04-26', $year.'-05-25'],
            [$year.'-05-26', $year.'-06-25'],
            [$year.'-06-26', $year.'-07-25'],
            [$year.'-07-26', $year.'-08-25'],
            [$year.'-08-26', $year.'-09-25'],
            [$year.'-09-26', $year.'-10-25'],
            [$year.'-10-26', $year.'-11-25'],
            [$year.'-11-26', $year.'-12-25']
        ];
    }
}
