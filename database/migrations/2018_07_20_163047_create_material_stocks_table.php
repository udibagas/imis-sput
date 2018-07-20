<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMaterialStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('material_stocks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('material_type', 1);
            $table->integer('seam_id')->nullable();
            $table->integer('stock_area_id');
            $table->date('dumping_date');
            $table->integer('customer_id');
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
        Schema::dropIfExists('material_stocks');
    }
}
