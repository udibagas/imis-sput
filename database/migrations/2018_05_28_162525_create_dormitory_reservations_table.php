<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDormitoryReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dormitory_reservations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('permit_number');
            $table->integer('employee_id')->unsigned();
            $table->integer('dormitory_room_id')->unsigned();
            $table->date('check_in');
            $table->date('check_out');
            $table->string('need');
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
        Schema::dropIfExists('dormitory_reservations');
    }
}
