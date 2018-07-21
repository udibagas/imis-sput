<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTimeOnStockDumping extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('stock_dumpings', function (Blueprint $table) {
            $table->time('time');
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
        Schema::table('stock_dumpings', function (Blueprint $table) {
            $table->dropColumn(['time', 'shift']);
        });
    }
}
