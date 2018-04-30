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
            $table->integer('unit_id');
            $table->integer('location_id');
            $table->integer('breakdown_category_id');
            $table->integer('km');
            $table->integer('hm');
            $table->dateTime('time_in');
            $table->dateTime('time_out')->nullable();
            $table->dateTime('time_ready')->nullable();
            $table->string('diagnosa')->nullable();
            $table->string('tindakan')->nullable();
            $table->string('description')->nullable();
            $table->string('warning_part')->nullable();
            $table->string('wo_number')->nullable();
            $table->integer('breakdown_status_id')->nullable();
            $table->integer('component_criteria_id')->nullable();
            $table->dateTime('update_pcr_time')->nullable();
            $table->dateTime('time_close')->nullable();
            $table->integer('update_pcr_by')->nullable();
            $table->boolean('status')->nullable();
            $table->integer('user_id')->nullable();
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
