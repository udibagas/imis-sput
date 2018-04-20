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
        Schema::create('stations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('description')->nullable();
            $table->timestamps();
        });

        Schema::create('pitstops', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('unit_id')->unsigned();
            $table->integer('station_id')->unsigned();
            $table->boolean('shift');
            $table->dateTime('time_in');
            $table->dateTime('time_out')->nullable();
            $table->string('description')->nullable();
            $table->integer('hm');
            $table->integer('user_id')->unsigned();
            $table->boolean('status');
            $table->timestamps();
        });

        Schema::table('pitstops', function (Blueprint $table) {
            $table->integer('unit_id')->unsigned()->change();
            $table->foreign('unit_id')->references('id')->on('units');
            $table->integer('station_id')->unsigned()->change();
            $table->foreign('station_id')->references('id')->on('stations');
            $table->integer('user_id')->unsigned()->change();
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
        Schema::dropIfExists('stations');
        Schema::dropIfExists('pitstops');
    }
}
