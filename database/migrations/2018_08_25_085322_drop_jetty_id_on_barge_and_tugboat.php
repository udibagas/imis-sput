<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropJettyIdOnBargeAndTugboat extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('barges', function (Blueprint $table) {
            $table->dropColumn('jetty_id');
        });

        Schema::table('tugboats', function (Blueprint $table) {
            $table->dropColumn('jetty_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('barges', function (Blueprint $table) {
            $table->integer('jetty_id')->nullable();
        });

        Schema::table('tugboats', function (Blueprint $table) {
            $table->integer('jetty_id')->nullable();
        });
    }
}
