<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BenerinTablePortActivities extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // delete and re-create
        Schema::dropIfExists('port_activities');

        Schema::create('port_activities', function (Blueprint $table) {
            $table->increments('id');
            $table->date('date');
            $table->time('time_start');
            $table->time('time_end');
            $table->integer('unit_id');
            $table->integer('employee_id');
            $table->integer('unit_activity_id');
            $table->integer('stock_area_id');
            $table->integer('customer_id');
            $table->string('material_type', 1);
            $table->integer('seam_id')->nullable();
            $table->integer('rit');
            $table->integer('volume');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('port_activities');

        Schema::create('port_activities', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('type');
            $table->date('date');
            $table->integer('from_area')->unsigned();
            $table->integer('from_sub_area')->unsigned();
            $table->integer('to_area')->unsigned();
            $table->integer('to_sub_area')->unsigned();
            $table->integer('unit_id')->unsigned();
            $table->integer('volume');
            $table->integer('user_id')->unsigned();
            $table->timestamps();
        });
    }
}
