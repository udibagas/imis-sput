<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddShiftOnPortActivities extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('port_activities', function (Blueprint $table) {
            $table->boolean('shift');
            $table->integer('hopper_id')->unsigned();
            $table->integer('hauler_id')->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('port_activities', function (Blueprint $table) {
            $table->dropColumn(['shift', 'hopper_id', 'hauler_id']);
        });
    }
}
