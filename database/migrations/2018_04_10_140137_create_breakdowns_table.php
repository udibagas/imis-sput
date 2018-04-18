<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBreakdownsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('breakdowns', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('equipment_id');
            $table->integer('location_id');
            $table->integer('breakdown_category_id');
            $table->integer('km');
            $table->integer('hm');
            $table->dateTime('time_in');
            $table->dateTime('time_out');
            $table->dateTime('time_ready');
            $table->string('diagnosa')->nullable();
            $table->string('tindakan')->nullable();
            $table->string('description')->nullable();
            $table->string('warning_part')->nullable();
            $table->string('wo_number')->nullable();
            $table->integer('breakdown_status_id');
            $table->integer('component_criteria_id');
            $table->dateTime('update_pcr_time');
            $table->integer('update_pcr_by');
            $table->boolean('status');
            $table->integer('user_id');
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
        Schema::dropIfExists('breakdowns');
    }
}
