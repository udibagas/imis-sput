<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIsiSolarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fuel_refills', function (Blueprint $table) {
            $table->date('date');
            $table->increments('id');
            $table->integer('fuel_tank_id')->unsigned();
            $table->integer('unit_id')->unsigned();
            $table->boolean('shift');
            $table->integer('total_recommended')->nullable();
            $table->integer('total_real');
            $table->integer('km');
            $table->integer('hm');
            $table->integer('km_last')->nullable();
            $table->integer('hm_last')->nullable();
            $table->integer('employee_id')->unsigned();
            $table->time('start_time');
            $table->time('finish_time');
            $table->integer('user_id')->unsigned();
            $table->string('insert_via', 10)->nullable();
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
        Schema::dropIfExists('fuel_refills');
    }
}
