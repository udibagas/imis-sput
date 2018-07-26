<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeSchemaForStockDumping extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('stock_dumpings', function (Blueprint $table) {
            $table->renameColumn('armada_unit_id', 'subcont_unit_id');
            $table->string('register_number', 20);
            $table->integer('area_id')->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('stock_dumpings', function (Blueprint $table) {
            $table->renameColumn('armada_unit_id', 'subcont_unit_id');
            $table->dropColumn(['register_number', 'area_id']);
        });
    }
}
