<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assets', function (Blueprint $table) {
            $table->increments('id');
            $table->string('reg_no');
            $table->string('name');
            $table->string('trademark');
            $table->string('version');
            $table->string('sn');
            $table->string('lifetime');
            $table->decimal('price');
            $table->string('year', 4);
            $table->integer('asset_location_id')->unsigned();
            $table->integer('asset_status_id')->unsigned();
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
        Schema::dropIfExists('assets');
    }
}
