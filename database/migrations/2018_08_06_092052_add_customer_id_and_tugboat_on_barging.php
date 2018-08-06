<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCustomerIdAndTugboatOnBarging extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bargings', function (Blueprint $table) {
            $table->integer('customer_id')->unsigned();
            $table->integer('tugboat_id')->unsigned();
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
            $table->dropColumn(['customer_id', 'tugboat_id']);
        });
    }
}
