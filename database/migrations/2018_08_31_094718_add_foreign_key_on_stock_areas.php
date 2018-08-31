<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeyOnStockAreas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('stock_areas', function (Blueprint $table) {
            $table->foreign('area_id')->references('id')->on('areas');
            $table->foreign('jetty_id')->references('id')->on('jetties');
            $table->foreign('hopper_id')->references('id')->on('hoppers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('stock_areas', function (Blueprint $table) {
            //
        });
    }
}
