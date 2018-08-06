<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDwellingTimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dwelling_times', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('barging_id')->unsigned();
            $table->integer('jetty_id')->unsigned(); // karena bisa pindah jetty
            $table->dateTime('time');
            $table->integer('volume')->default(0); // buat mencatat progress
            $table->boolean('status'); // start, loading, delay, br, dsb
            $table->string('description')->nullable();
            $table->integer('user_id')->unsigned(); // yg update siapa
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
        Schema::dropIfExists('dwelling_times');
    }
}
