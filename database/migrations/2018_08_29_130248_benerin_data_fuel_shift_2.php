<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BenerinDataFuelShift2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fuel_refills', function (Blueprint $table) {
            $sql = "UPDATE fuel_refills SET `date` = DATE_SUB(`date`, INTERVAL 1 DAY) WHERE shift = 2";
            DB::update($sql);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fuel_refills', function (Blueprint $table) {
            //
        });
    }
}
