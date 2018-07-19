<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStockDumpingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_dumpings', function (Blueprint $table) {
            $table->increments('id');
            $table->date('date');
            $table->integer('unit_id')->unsigned();
            $table->integer('employee_id')->unsigned();
            $table->integer('stock_area_id')->unsigned();
            $table->integer('volume');
            $table->string('material_type', 1);
            $table->integer('seam_id')->unsigned()->nullable();
            $table->integer('customer_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->string('insert_via', 20)->default('web');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stock_dumpings');
    }
}
