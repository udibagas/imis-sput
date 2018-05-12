<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFlowMetersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('flow_meters', function (Blueprint $table) {
            $table->increments('id');
            $table->date('date');
            $table->decimal('flowmeter_start');
            $table->decimal('flowmeter_end');
            $table->decimal('sounding_start');
            $table->decimal('sounding_end');
            $table->decimal('volume_by_sounding');
            $table->integer('fuel_tank_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->string('status', 1);
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
        Schema::dropIfExists('flow_meters');
    }
}
