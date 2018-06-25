<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSadIdOnFlowMeters extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('flow_meters', function (Blueprint $table) {
            $table->integer('sadp_id')->unsigned()->nullable();
            $table->integer('fuel_tank_id')->unsigned()->nullable()->change();
            $table->integer('transfer_to_fuel_tank_id')->unsigned()->nullable();
            $table->boolean('shift');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('flow_meters', function (Blueprint $table) {
            $table->dropColumn(['sadp_id', 'shift', 'transfer_to_fuel_tank_id']);
        });
    }
}
