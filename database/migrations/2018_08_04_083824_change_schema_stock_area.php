<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeSchemaStockArea extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('stock_areas', function (Blueprint $table) {
            $table->renameColumn('jetty_id', 'area_id');
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
            $table->renameColumn('area_id', 'jetty_id');
        });
    }
}
