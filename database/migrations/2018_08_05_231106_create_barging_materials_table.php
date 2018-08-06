<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBargingMaterialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('barging_materials', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('barging_id')->unsigned();
            $table->integer('customer_id')->unsigned();
            $table->string('material_type', 1);
            $table->integer('seam_id')->unsigned()->nullable();
            $table->integer('volume');
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
        Schema::dropIfExists('barging_materials');
    }
}
