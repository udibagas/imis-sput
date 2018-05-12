<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePitstopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pitstops', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('unit_id')->unsigned();
            $table->integer('location_id')->unsigned();
            $table->boolean('shift');
            $table->dateTime('time_in');
            $table->dateTime('time_out')->nullable();
            $table->string('description')->nullable();
            $table->integer('hm');
            $table->integer('user_id')->unsigned();
            $table->boolean('status')->default(0);
            $table->timestamps();
        });

        Schema::table('pitstops', function (Blueprint $table) {
            $table->foreign('unit_id')->references('id')->on('units');
            $table->foreign('locationn_id')->references('id')->on('locations');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pitstops');
    }
}
