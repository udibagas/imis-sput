<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveTotalRoomAndCapacity extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dormitories', function (Blueprint $table) {
            $table->dropColumn(['total_room', 'capacity']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('dormitories', function (Blueprint $table) {
            $table->integer('total_room')->default(0);
            $table->integer('capacity')->default(0);
        });
    }
}
