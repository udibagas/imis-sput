<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveStockAndAgeOnStockArea extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('stock_areas', function (Blueprint $table) {
            $table->dropColumn(['stock', 'age']);
            $table->string('position', 1)->nullable()->change();
            $table->smallInteger('order')->nullable()->change();
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
            $table->integer('stock');
            $table->integer('age');
        });
    }
}
