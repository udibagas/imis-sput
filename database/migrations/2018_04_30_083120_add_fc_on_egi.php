<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFcOnEgi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('egis', function (Blueprint $table) {
            $table->integer('fc')->nullable();
        });

        Schema::table('units', function (Blueprint $table) {
            $table->dropColumn('fc');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('egis', function (Blueprint $table) {
            $table->dropColumn('fc');
        });

        Schema::table('units', function (Blueprint $table) {
            $table->integer('fc')->nullable();
        });
    }
}
