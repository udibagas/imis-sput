<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DeleteUnnecessaryFieldOnUnits extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('units', function (Blueprint $table) {
            $table->dropColumn(['jetty_id', 'ton_pen_rit_hi', 'ton_pen_rit_lo']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('units', function (Blueprint $table) {
            $table->decimal('ton_pen_rit_hi')->nullable();
            $table->decimal('ton_pen_rit_lo')->nullable();
            $table->integer('jetty_id')->nullable();
        });
    }
}
