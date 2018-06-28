<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTonPerRitOnUnits extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('units', function (Blueprint $table) {
            $table->string('type', 20)->nullable();
            $table->decimal('ton_pen_rit_hi')->nullable();
            $table->decimal('ton_pen_rit_lo')->nullable();
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
            $table->dropColumn(['type', 'ton_pen_rit_hi', 'ton_pen_rit_lo']);
        });
    }
}
