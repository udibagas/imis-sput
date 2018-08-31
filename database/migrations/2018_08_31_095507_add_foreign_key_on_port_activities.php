<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeyOnPortActivities extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('port_activities', function (Blueprint $table) {
            $table->integer('unit_id')->unsigned()->change();
            $table->foreign('unit_id')->references('id')->on('units');
            $table->integer('employee_id')->unsigned()->change();
            $table->foreign('employee_id')->references('id')->on('employees');
            $table->foreign('hopper_id')->references('id')->on('hoppers');
            $table->foreign('material_stock_id')->references('id')->on('material_stocks');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('seam_id')->references('id')->on('seams');
            $table->foreign('customer_id')->references('id')->on('customers');
            $table->foreign('contractor_id')->references('id')->on('contractors');
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
            //
        });
    }
}
