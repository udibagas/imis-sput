<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeyOnBargings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bargings', function (Blueprint $table) {
            $table->foreign('jetty_id')->references('id')->on('jetties');
            $table->foreign('barge_id')->references('id')->on('barges');
            $table->foreign('buyer_id')->references('id')->on('buyers');
            $table->foreign('customer_id')->references('id')->on('customers');
            $table->foreign('tugboat_id')->references('id')->on('tugboats');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bargings', function (Blueprint $table) {
            //
        });
    }
}
