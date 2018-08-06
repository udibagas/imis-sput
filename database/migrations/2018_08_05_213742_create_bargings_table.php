<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBargingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bargings', function (Blueprint $table) {
            $table->increments('id');
            $table->dateTime('start');
            $table->dateTime('stop')->nullable();
            $table->integer('jetty_id')->unsigned();
            $table->integer('barge_id')->unsigned();
            $table->integer('buyer_id')->unsigned();
            $table->integer('volume');
            $table->integer('progress')->default(0);
            $table->boolean('status')->default(0);
            $table->string('description')->nullable();
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
        Schema::dropIfExists('bargings');
    }
}
