<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeNullableBreakdownTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('breakdowns', function (Blueprint $table) {
            $table->dateTime('time_out')->nullable()->change();
            $table->dateTime('time_ready')->nullable()->change();
            $table->string('diagnosa')->nullable()->change();
            $table->string('tindakan')->nullable()->change();
            $table->string('description')->nullable()->change();
            $table->string('warning_part')->nullable()->change();
            $table->string('wo_number')->nullable()->change();
            $table->integer('breakdown_status_id')->nullable()->change();
            $table->integer('component_criteria_id')->nullable()->change();
            $table->dateTime('update_pcr_time')->nullable()->change();
            $table->integer('update_pcr_by')->nullable()->change();
            $table->boolean('status')->nullable()->change();
            $table->integer('user_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('breakdowns', function (Blueprint $table) {
            //
        });
    }
}
