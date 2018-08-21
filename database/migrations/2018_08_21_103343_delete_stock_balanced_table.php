<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DeleteStockBalancedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('stock_balanceds');
    }

    /**
    * Reverse the migrations.
    *
    * @return void
    */
    public function down()
    {
        Schema::create('stock_balanceds', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('area_id')->unsigned();
            $table->integer('sub_area_id')->unsigned();
            $table->integer('customer_id')->unsigned();
            $table->date('dumping_date'); // untuk mengetahui umur
            $table->integer('volume');
            $table->integer('seam_id')->unsigned();
            $table->timestamps();
        });
    }
}
