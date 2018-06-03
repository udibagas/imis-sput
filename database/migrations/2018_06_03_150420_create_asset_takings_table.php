<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssetTakingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asset_takings', function (Blueprint $table) {
            $table->increments('id');
            $table->date('date');
            $table->integer('asset_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->integer('asset_location_id')->unsigned();
            $table->integer('asset_status_id')->unsigned();
            $table->string('note')->nullable();
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
        Schema::dropIfExists('asset_takings');
    }
}
