<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDormitoryRoomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dormitory_rooms', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('dormitory_id')->unsigned();
            $table->string('name', 20);
            $table->integer('capacity');
            $table->boolean('status')->default(1);
            $table->string('pic', 30)->nullable();
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
        Schema::dropIfExists('dormitory_rooms');
    }
}
