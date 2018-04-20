<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeyOnBreakdowns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('breakdowns', function (Blueprint $table) {
            $table->integer('unit_id')->unsigned()->change();
            $table->foreign('unit_id')->references('id')->on('units');
            $table->integer('user_id')->unsigned()->change();
            $table->foreign('user_id')->references('id')->on('users');
            $table->integer('location_id')->unsigned()->change();
            $table->foreign('location_id')->references('id')->on('locations');
            $table->integer('breakdown_category_id')->unsigned()->change();
            $table->foreign('breakdown_category_id')->references('id')->on('breakdown_categories');
            $table->integer('breakdown_status_id')->unsigned()->change();
            $table->foreign('breakdown_status_id')->references('id')->on('breakdown_statuses');
            $table->integer('component_criteria_id')->unsigned()->change();
            $table->foreign('component_criteria_id')->references('id')->on('component_criterias');
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
