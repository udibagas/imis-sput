<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePortActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('port_activities', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('type');
            $table->date('date');
            $table->integer('from_area')->unsigned();
            $table->integer('from_sub_area')->unsigned();
            $table->integer('to_area')->unsigned();
            $table->integer('to_sub_area')->unsigned();
            $table->integer('unit_id')->unsigned();
            $table->integer('volume');
            $table->integer('user_id')->unsigned();
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
        Schema::dropIfExists('port_activities');
    }
}
