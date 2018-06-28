<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStokAreasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_areas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('jetty_id')->unsigned();
            $table->string('name', 20);
            $table->string('position', 1);
            $table->tinyInteger('order')->default(0);
            $table->integer('capacity')->default(0);
            $table->integer('stock')->default(0);
            $table->smallInteger('age')->nullable();
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
        Schema::dropIfExists('stok_areas');
    }
}
