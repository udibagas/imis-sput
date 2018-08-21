<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddVolumeProgressOnBargingMaterial extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('barging_materials', function (Blueprint $table) {
            $table->integer('volume_progress')->default(0);
            $table->integer('volume_by_draught_survey')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('barging_materials', function (Blueprint $table) {
            $table->dropColumn(['volume_progress', 'volume_by_draught_survey']);
        });
    }
}
