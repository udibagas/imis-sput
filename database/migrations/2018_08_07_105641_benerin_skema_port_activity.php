<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BenerinSkemaPortActivity extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('port_activities', function (Blueprint $table) {
            $table->boolean('unit_activity_id')->change();
            $table->integer('hopper_id')->unsigned()->nullable()->change();
            $table->integer('hauler_id')->unsigned()->nullable()->change();
            $table->integer('rit')->nullable()->change();
            $table->integer('volume')->nullable()->change();
            $table->integer('material_stock_id')->unsigned()->nullable();
            $table->dropColumn(['stock_area_id', 'customer_id', 'seam_id', 'material_type']);
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
            $table->integer('stock_area_id')->unsigned()->nullable();
            $table->integer('customer_id')->unsigned()->nullable();
            $table->integer('seam_id')->unsigned()->nullable();
            $table->string('material_type', 1)->nullable();
            $table->dropColumn(['material_stock_id']);
        });
    }
}
