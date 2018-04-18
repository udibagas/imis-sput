<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFuelTanksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fuel_tanks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 30);
            $table->string('description')->nullable();
            $table->decimal('capacity', 8, 3);
            $table->decimal('stock', 8, 3)->nullable();
            $table->datetime('last_stock_time')->nullable();
            // location related
            $table->datetime('last_position_time')->nullable();
            $table->decimal('latitude', 9, 6)->nullable();
            $table->decimal('longitude', 9, 6)->nullable();
            $table->decimal('altitude', 6, 2)->nullable();
            $table->decimal('heading', 5, 2)->nullable();
            $table->decimal('speed', 5, 2)->nullable();
            $table->integer('accuracy')->nullable();
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
        Schema::dropIfExists('fuel_tanks');
    }
}
